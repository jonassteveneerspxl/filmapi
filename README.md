# 🎬 FilmTracker API

Een REST API gebouwd in pure PHP om films en series bij te houden.

## Technologieën
- PHP 8+ (OOP, namespaces)
- MySQL met PDO
- Composer met PSR-4 autoloading
- Vanilla JS frontend

## Installatie

1. Clone de repo in je `htdocs` map
2. Voer `composer install` uit
3. Maak een database aan genaamd `filmapi`
4. Importeer `database.sql`
5. Surf naar `http://localhost/filmapi/public/frontend/`

## API Endpoints

| Methode | Endpoint | Beschrijving |
|---|---|---|
| GET | /films | Alle films ophalen |
| GET | /films/{id} | Één film ophalen |
| POST | /films | Nieuwe film toevoegen |
| PUT | /films/{id} | Film bijwerken |
| DELETE | /films/{id} | Film verwijderen |

## Voorbeeld request

\`\`\`json
POST /films
{
    "titel": "Inception",
    "type": "film",
    "genre": "Sci-Fi",
    "jaar": 2010,
    "beoordeling": 9,
    "bekeken": true
}
\`\`\`