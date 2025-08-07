<?php

namespace Models;

require_once __DIR__ . '/../../database/Database.php';

use Config\Database\Database;
use PDO;

class DeleteAnnonceModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAnnonceOwner(int $annonceId): ?int
    {
        $stmt = $this->db->prepare("SELECT user_id FROM listing WHERE id = :id");
        $stmt->execute(['id' => $annonceId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['user_id'] : null;
    }

    public function deleteAnnonce(int $annonceId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM listing WHERE id = :id");
        return $stmt->execute(['id' => $annonceId]);
    }
}
