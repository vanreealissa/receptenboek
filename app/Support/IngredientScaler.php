<?php

namespace App\Support;

/**
 * Rekent de hoeveelheden in ingrediëntregels om naar een ander aantal porties.
 *
 * "200 g bloem" × 1,5 → "300 g bloem". Regels zonder getal vooraan
 * (zoals "snufje zout") blijven ongewijzigd.
 */
class IngredientScaler
{
    private const FRACTIONS = ['¼' => 0.25, '½' => 0.5, '¾' => 0.75];

    public function scale(string $line, float $factor): string
    {
        $pattern = '/^\s*(\d+\s+\d+\/\d+|\d+\/\d+|\d+(?:[.,]\d+)?|[¼½¾]|\d+[¼½¾])(?=\s|$)/u';

        if ($factor === 1.0 || ! preg_match($pattern, $line, $match)) {
            return $line;
        }

        $amount = $this->parse($match[1]) * $factor;

        return $this->format($amount).mb_substr($line, mb_strlen($match[0]));
    }

    public function parse(string $value): float
    {
        $value = trim($value);

        foreach (self::FRACTIONS as $glyph => $fraction) {
            if (str_ends_with($value, $glyph)) {
                $whole = trim(mb_substr($value, 0, -1));

                return ($whole === '' ? 0 : (float) $whole) + $fraction;
            }
        }

        if (preg_match('/^(?:(\d+)\s+)?(\d+)\/(\d+)$/', $value, $m)) {
            return (float) ($m[1] ?: 0) + ((int) $m[2] / max(1, (int) $m[3]));
        }

        return (float) str_replace(',', '.', $value);
    }

    public function format(float $amount): string
    {
        if ($amount >= 10) {
            return (string) round($amount);
        }

        $whole = (int) floor($amount);
        $rest = round($amount - $whole, 2);

        foreach (self::FRACTIONS as $glyph => $fraction) {
            if (abs($rest - $fraction) < 0.01) {
                return ($whole ?: '').$glyph;
            }
        }

        $rounded = round($amount, 1);

        return $rounded == floor($rounded)
            ? (string) (int) $rounded
            : str_replace('.', ',', (string) $rounded);
    }
}
