<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class FilmModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Alle films ophalen
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM films ORDER BY aangemaakt DESC");
        return $stmt->fetchAll();
    }

    // Één film ophalen op ID
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM films WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // Nieuwe film toevoegen
    public function create(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO films (titel, type, genre, jaar, beoordeling, bekeken)
            VALUES (:titel, :type, :genre, :jaar, :beoordeling, :bekeken)
        ");

        $stmt->execute([
            ':titel'       => $data['titel'],
            ':type'        => $data['type'],
            ':genre'       => $data['genre'] ?? null,
            ':jaar'        => $data['jaar'] ?? null,
            ':beoordeling' => $data['beoordeling'] ?? null,
            ':bekeken'     => $data['bekeken'] ?? false,
        ]);

        return (int) $this->db->lastInsertId();
    }

    // Film bijwerken
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE films
            SET titel = :titel, type = :type, genre = :genre,
                jaar = :jaar, beoordeling = :beoordeling, bekeken = :bekeken
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id'          => $id,
            ':titel'       => $data['titel'],
            ':type'        => $data['type'],
            ':genre'       => $data['genre'] ?? null,
            ':jaar'        => $data['jaar'] ?? null,
            ':beoordeling' => $data['beoordeling'] ?? null,
            ':bekeken'     => $data['bekeken'] ?? false,
        ]);
    }

    // Film verwijderen
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM films WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}