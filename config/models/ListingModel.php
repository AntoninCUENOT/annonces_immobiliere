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

    public function getTotalListingsCountByPropertyType(int $propertyTypeId): int
    {
        $sql = "SELECT COUNT(*) FROM listing WHERE property_type_id = :typeId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':typeId', $propertyTypeId, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getListingsByPropertyType(int $propertyTypeId, int $limit, int $offset): array
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
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':typeId', $propertyTypeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFilteredListingsCount(int $propertyTypeId, array $filters): int
    {
        $sql = "SELECT COUNT(*) FROM listing WHERE property_type_id = :typeId";
        $params = [':typeId' => $propertyTypeId];

        if (!empty($filters['ville'])) {
            $sql .= " AND city LIKE :ville";
            $params[':ville'] = '%' . $filters['ville'] . '%';
        }
        if (!empty($filters['prix_max'])) {
            $sql .= " AND price <= :prix_max";
            $params[':prix_max'] = $filters['prix_max'];
        }
        if (!empty($filters['transaction_type_id'])) {
            $sql .= " AND transaction_type_id = :transaction_type_id";
            $params[':transaction_type_id'] = $filters['transaction_type_id'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function getFilteredListings(int $propertyTypeId, ?int $limit, ?int $offset, array $filters): array
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
    ";

        $params = [':typeId' => $propertyTypeId];

        if (!empty($filters['ville'])) {
            $sql .= " AND l.city LIKE :ville";
            $params[':ville'] = '%' . $filters['ville'] . '%';
        }
        if (!empty($filters['prix_max'])) {
            $sql .= " AND l.price <= :prix_max";
            $params[':prix_max'] = $filters['prix_max'];
        }

        $sql .= " ORDER BY l.created_at DESC";

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
