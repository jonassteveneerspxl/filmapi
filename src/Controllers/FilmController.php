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

        if (empty($data['titel']) || empty($data['type'])) {
            $this->json(['error' => 'Titel en type zijn verplicht'], 422);
            return;
        }

        if (!in_array($data['type'], ['film', 'serie'])) {
            $this->json(['error' => 'Type moet film of serie zijn'], 422);
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

        if (empty($data['titel']) || empty($data['type'])) {
            $this->json(['error' => 'Titel en type zijn verplicht'], 422);
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