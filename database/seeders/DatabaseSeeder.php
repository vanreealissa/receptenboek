<?php

namespace Database\Seeders;

use App\Enums\Category;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Spaghetti aglio e olio',
                'category' => Category::Diner,
                'description' => 'Snelle Italiaanse klassieker met knoflook, olijfolie en een beetje pit.',
                'prep_minutes' => 15,
                'servings' => 2,
                'ingredients' => "200 g spaghetti\n4 teentjes knoflook\n5 el olijfolie\n½ tl chilivlokken\n1 handje peterselie\nsnufje zout",
                'steps' => "Kook de spaghetti in ruim water met zout beetgaar.\nSnijd de knoflook in plakjes en bak zachtjes in de olijfolie tot hij goudgeel is.\nVoeg de chilivlokken toe en haal de pan van het vuur.\nSchep de spaghetti met een scheut kookvocht door de olie.\nMaak af met fijngehakte peterselie.",
            ],
            [
                'title' => 'Hollandse pannenkoeken',
                'category' => Category::Lunch,
                'description' => 'Dunne pannenkoeken zoals oma ze maakte. Lekker met stroop of spek.',
                'prep_minutes' => 30,
                'servings' => 4,
                'ingredients' => "250 g bloem\n500 ml melk\n2 eieren\nsnufje zout\n3 el boter om te bakken",
                'steps' => "Doe de bloem en het zout in een kom en maak een kuiltje.\nVoeg de eieren en de helft van de melk toe en klop tot een glad beslag.\nVoeg al kloppend de rest van de melk toe.\nBak de pannenkoeken één voor één in een beetje boter.",
            ],
            [
                'title' => 'Overnight oats met appel',
                'category' => Category::Ontbijt,
                'description' => 'Avond klaarzetten, ochtend meteen eten.',
                'prep_minutes' => 5,
                'servings' => 1,
                'ingredients' => "50 g havermout\n150 ml melk\n2 el Griekse yoghurt\n½ appel\n1 tl kaneel\n1 tl honing",
                'steps' => "Meng havermout, melk, yoghurt en kaneel in een pot.\nRasp de appel erdoor.\nZet een nacht in de koelkast.\nSchenk er 's ochtends de honing over.",
            ],
            [
                'title' => 'Appeltaart',
                'category' => Category::Bakken,
                'description' => 'Ouderwetse appeltaart met een deksel van roosterdeeg.',
                'prep_minutes' => 90,
                'servings' => 10,
                'ingredients' => "300 g zelfrijzend bakmeel\n200 g roomboter\n150 g basterdsuiker\n1 ei\n1 kg zoetzure appels\n1 el kaneel\n75 g rozijnen",
                'steps' => "Verwarm de oven voor op 175 °C.\nKneed bakmeel, boter, suiker en het grootste deel van het ei tot een deeg.\nBekleed een ingevette springvorm met tweederde van het deeg.\nSchil en snijd de appels en meng met kaneel en rozijnen.\nVul de vorm en leg van de rest van het deeg repen over de vulling.\nBestrijk met de rest van het ei en bak in ongeveer 60 minuten goudbruin.",
            ],
            [
                'title' => 'Tomatensoep met balletjes',
                'category' => Category::Diner,
                'description' => 'Verse tomatensoep met kleine gehaktballetjes.',
                'prep_minutes' => 45,
                'servings' => 4,
                'ingredients' => "1 kg tomaten\n1 ui\n2 teentjes knoflook\n1 l groentebouillon\n250 g rundergehakt\n1 el tomatenpuree\nsnufje peper",
                'steps' => "Fruit de ui en knoflook in een soeppan.\nVoeg de tomaten, tomatenpuree en bouillon toe en laat 20 minuten zachtjes koken.\nDraai kleine balletjes van het gehakt.\nPureer de soep en breng op smaak met peper.\nGaar de balletjes 8 minuten in de soep.",
            ],
            [
                'title' => 'Chocolademousse',
                'category' => Category::Nagerecht,
                'description' => 'Luchtige mousse van pure chocolade.',
                'prep_minutes' => 20,
                'servings' => 4,
                'ingredients' => "150 g pure chocolade\n3 eieren\n2 el suiker\n200 ml slagroom",
                'steps' => "Smelt de chocolade au bain-marie en laat iets afkoelen.\nSplits de eieren en roer de dooiers door de chocolade.\nKlop de eiwitten met de suiker stijf.\nKlop de slagroom lobbig.\nSpatel eerst de slagroom en daarna het eiwit door de chocolade.\nVerdeel over glazen en laat minstens 3 uur opstijven in de koelkast.",
            ],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
