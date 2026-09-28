# Receptenboek

Een persoonlijk receptenboek gebouwd met Laravel. Recepten toevoegen, bewerken en
verwijderen, zoeken op gerecht of ingrediënt, en de hoeveelheden automatisch laten
omrekenen naar het aantal personen dat mee-eet.

## Functies

- Volledige CRUD voor recepten met nette, Nederlandse URL's
  (`/recepten/nieuw`, `/recepten/appeltaart/bewerken`)
- Zoeken in titels en ingrediënten, filteren op categorie, paginering
- Porties aanpassen: "250 g bloem" voor 4 personen wordt "375 g bloem" voor 6.
  Ook breuken als `½` en `1/2` en decimalen als `1,5` worden begrepen.
- Unieke slugs, ook als twee recepten dezelfde naam hebben
- Zes voorbeeldrecepten om mee te beginnen

## Wat laat dit project zien?

| Onderdeel | Waar |
| --- | --- |
| Resource controller en `Route::resourceVerbs` | `routes/web.php`, `AppServiceProvider` |
| PHP-enum als Eloquent-cast | `app/Enums/Category.php`, `app/Models/Recipe.php` |
| Model events voor slugs | `Recipe::booted()` |
| Losse, testbare hulpklasse | `app/Support/IngredientScaler.php` |
| Unit tests met een data provider | `tests/Unit/IngredientScalerTest.php` |
| Feature tests voor de hele CRUD | `tests/Feature/RecipeTest.php` |

## Installeren

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Gebruik je Laravel Herd? Zet de map in `~/Herd` en open http://receptenboek.test.

## Testen

```bash
php artisan test
```

## Let op

Iedereen die de site kan openen, kan in deze demo recepten wijzigen. Voor een
openbare versie voeg je inloggen toe, bijvoorbeeld met Laravel Breeze.
