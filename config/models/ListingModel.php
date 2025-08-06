<?php

namespace Config\Models;

require_once __DIR__ . '/../database/Database.php';

use Config\Database\Database;
use PDO;

class ListingModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAllListings(): array
    {
        $sql = "
            SELECT 
                l.id, l.title, l.description, l.price, l.city, l.image_url,
                pt.name AS property_type,
                tt.name AS transaction_type
            FROM listing l
            JOIN propertyType pt ON l.property_type_id = pt.id
            JOIN transactionType tt ON l.transaction_type_id = tt.id
            ORDER BY l.created_at DESC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getListingsByPropertyType(int $propertyTypeId): array
{
    $sql = "
        SELECT 
            l.id, l.title, l.description, l.price, l.city, l.image_url,
            pt.name AS property_type,
            tt.name AS transaction_type
        FROM listing l
        JOIN propertyType pt ON l.property_type_id = pt.id
        JOIN transactionType tt ON l.transaction_type_id = tt.id
        WHERE l.property_type_id = :typeId
        ORDER BY l.created_at DESC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['typeId' => $propertyTypeId]);
    return $stmt->fetchAll();
}

}
