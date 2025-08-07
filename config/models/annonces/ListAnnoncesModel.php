<?php

namespace Models\Annonces;

require_once __DIR__ . '/../../database/Database.php';

use Config\Database\Database;
use PDO;

class ListAnnoncesModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAnnoncesByRole(string $role, int $userId): array
    {
        if ($role === 'admin') {
            $query = "SELECT * FROM listing ORDER BY created_at DESC";
            $stmt = $this->db->query($query);
        } elseif ($role === 'agent') {
            $query = "SELECT * FROM listing WHERE user_id = :user_id ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['user_id' => $userId]);
        } else {
            // user : pas d'accès
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
