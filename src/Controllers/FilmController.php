<?php

namespace App\Controllers;

use App\Models\FilmModel;

class FilmController
{
    private FilmModel $model;

    public function __construct()
    {
        $this->model = new FilmModel();
    }

    // GET /films
    public function index(): void
    {
        $films = $this->model->getAll();
        $this->json($films);
    }

    // GET /films/{id}
    public function show(string $id): void
    {
        $film = $this->model->getById((int) $id);

        if (!$film) {
            $this->json(['error' => 'Film niet gevonden'], 404);
            return;
        }

        $this->json($film);
    }

    // POST /films
    public function store(): void
    {
        $data = $this->getBody();

        // Titel en type validatie
        if (empty($data['titel']) || empty($data['type'])) {
            $this->json(['error' => 'Titel en type zijn verplicht'], 422);
            return;
        }

        // Type validatie
        if (!in_array($data['type'], ['film', 'serie'])) {
            $this->json(['error' => 'Type moet film of serie zijn'], 422);
            return;
        }

        // Jaar validatie
        if (!empty($data['jaar']) && ($data['jaar'] < 1888 || $data['jaar'] > 2100)) {
            $this->json(['error' => 'Jaar moet tussen 1888 en 2100 liggen'], 422);
            return;
        }

        // Beoordeling validatie
        if (!empty($data['beoordeling']) && ($data['beoordeling'] < 1 || $data['beoordeling'] > 10)) {
            $this->json(['error' => 'Beoordeling moet tussen 1 en 10 liggen'], 422);
            return;
        }

        $id   = $this->model->create($data);
        $film = $this->model->getById($id);
        $this->json($film, 201);
    }

    // PUT /films/{id}
    public function update(string $id): void
    {
        $film = $this->model->getById((int) $id);

        if (!$film) {
            $this->json(['error' => 'Film niet gevonden'], 404);
            return;
        }

        $data = $this->getBody();

        // Titel en type validatie
        if (empty($data['titel']) || empty($data['type'])) {
            $this->json(['error' => 'Titel en type zijn verplicht'], 422);
            return;
        }

        // Jaar validatie
        if (!empty($data['jaar']) && ($data['jaar'] < 1888 || $data['jaar'] > 2100)) {
            $this->json(['error' => 'Jaar moet tussen 1888 en 2100 liggen'], 422);
            return;
        }

        // Beoordeling validatie
        if (!empty($data['beoordeling']) && ($data['beoordeling'] < 1 || $data['beoordeling'] > 10)) {
            $this->json(['error' => 'Beoordeling moet tussen 1 en 10 liggen'], 422);
            return;
        }

        $this->model->update((int) $id, $data);
        $film = $this->model->getById((int) $id);
        $this->json($film);
    }

    // DELETE /films/{id}
    public function destroy(string $id): void
    {
        $film = $this->model->getById((int) $id);

        if (!$film) {
            $this->json(['error' => 'Film niet gevonden'], 404);
            return;
        }

        $this->model->delete((int) $id);
        $this->json(['message' => 'Film verwijderd']);
    }

    // GET /films/filter?type=film&bekeken=true
    public function filter(): void
    {
        $type    = $_GET['type']    ?? null;
        $bekeken = isset($_GET['bekeken']) ? (bool) $_GET['bekeken'] : null;

        $films = $this->model->filter($type, $bekeken);
        $this->json($films);
    }

    // JSON response sturen
    private function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        echo json_encode($data);
    }

    // Request body inlezen (voor POST en PUT)
    private function getBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
}