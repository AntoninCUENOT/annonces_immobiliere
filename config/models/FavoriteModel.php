<?php

namespace Models;

require_once __DIR__ . '/../database/Database.php';
use Config\Database\Database;
use PDO;

class FavoriteModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function addFavorite(int $userId, int $listingId): bool
    {
        $stmt = $this->db->prepare("INSERT INTO favorite (user_id, listing_id) VALUES (:user_id, :listing_id)");
        return $stmt->execute(['user_id' => $userId, 'listing_id' => $listingId]);
    }

    public function removeFavorite(int $userId, int $listingId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM favorite WHERE user_id = :user_id AND listing_id = :listing_id");
        return $stmt->execute(['user_id' => $userId, 'listing_id' => $listingId]);
    }

    public function isFavorite(int $userId, int $listingId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = :user_id AND listing_id = :listing_id");
        $stmt->execute(['user_id' => $userId, 'listing_id' => $listingId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getFavoritesByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT l.* FROM favorite f
            JOIN listing l ON l.id = f.listing_id
            WHERE f.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
