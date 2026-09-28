<?php

namespace App\Enums;

enum Category: string
{
    case Ontbijt = 'ontbijt';
    case Lunch = 'lunch';
    case Diner = 'diner';
    case Nagerecht = 'nagerecht';
    case Bakken = 'bakken';

    public function label(): string
    {
        return $this->name;
    }
}
