<?php

namespace Tests\Unit;

use App\Support\IngredientScaler;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class IngredientScalerTest extends TestCase
{
    #[DataProvider('cases')]
    public function test_it_scales_ingredient_lines(string $line, float $factor, string $expected): void
    {
        $this->assertSame($expected, (new IngredientScaler)->scale($line, $factor));
    }

    public static function cases(): array
    {
        return [
            'hele getallen' => ['200 g bloem', 1.5, '300 g bloem'],
            'decimale komma' => ['1,5 el olijfolie', 2, '3 el olijfolie'],
            'breuk met schuine streep' => ['1/2 ui', 2, '1 ui'],
            'breukteken' => ['½ tl kaneel', 3, '1½ tl kaneel'],
            'getal met breukteken' => ['1½ el suiker', 2, '3 el suiker'],
            'afronden boven de tien' => ['250 g spaghetti', 0.333, '83 g spaghetti'],
            'kleine hoeveelheden' => ['1 ei', 0.5, '½ ei'],
            'decimaal resultaat' => ['2 eieren', 0.6, '1,2 eieren'],
            'geen hoeveelheid' => ['snufje zout', 2, 'snufje zout'],
            'factor één' => ['200 g bloem', 1, '200 g bloem'],
            'getal in de tekst' => ['bakken op 175 °C', 2, 'bakken op 175 °C'],
        ];
    }
}
