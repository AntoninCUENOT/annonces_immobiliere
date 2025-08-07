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
        $stmt = $this->db->prepare("
            UPDATE listing SET
                title = :title,
                description = :description,
                price = :price,
                city = :city,
                image_url = :image_url,
                property_type_id = :property_type_id,
                transaction_type_id = :transaction_type_id
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'city' => $data['city'],
            'image_url' => $data['image_url'],
            'property_type_id' => $data['property_type_id'],
            'transaction_type_id' => $data['transaction_type_id']
        ]);
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
}
