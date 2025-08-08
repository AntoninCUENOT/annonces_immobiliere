<?php

namespace Models;

require_once __DIR__ . '/../../database/Database.php';

use Config\Database\Database;
use PDO;

class EditAnnonceModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAnnonceById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM listing WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function updateAnnonce(int $id, array $data): bool
    {
        $existing = $this->getAnnonceById($id);
        if (!$existing) {
            return false;
        }

        $fieldsToUpdate = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $existing)) {
                continue;
            }

            if ($value != $existing[$key]) {
                $fieldsToUpdate[] = "$key = :$key";
                $params[$key] = $value;
            }
        }

        if (empty($fieldsToUpdate)) {
            return true;
        }

        $sql = "UPDATE listing SET " . implode(', ', $fieldsToUpdate) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    public function getPropertyTypes(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM propertyType");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTransactionTypes(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM transactionType");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPDO(): PDO
    {
        return $this->db;
    }
}
