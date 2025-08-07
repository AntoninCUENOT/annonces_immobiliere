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


    public function getListingsByPropertyType(int $propertyTypeId, ?int $limit = null): array
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

    if ($limit !== null) {
        $sql .= " LIMIT :limit";
    }

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':typeId', $propertyTypeId, PDO::PARAM_INT);

    if ($limit !== null) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}


}
