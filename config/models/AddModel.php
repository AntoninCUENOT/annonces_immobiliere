<?php

namespace App\Models;

require_once __DIR__ . '/../database/Database.php';

use Config\Database\Database;
use PDO;

class AddModel
{
    public function validateForm(array $data): array
    {
        $requiredFields = ['image', 'title', 'price', 'city', 'description', 'transactionType', 'propertyType'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field] ?? ''))) {
                $errors[] = "Le champ $field est requis.";
            }
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Insertion en BDD
        $db = Database::getConnection();
        $stmt = $db->prepare("
            INSERT INTO listing (title, description, price, city, image_url, property_type_id, transaction_type_id, user_id)
            VALUES (:title, :description, :price, :city, :image_url, :property_type_id, :transaction_type_id, :user_id)
        ");

        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':city' => $data['city'],
            ':image_url' => $data['image'], // À remplacer par un vrai chemin d'upload plus tard
            ':property_type_id' => $data['propertyType'],
            ':transaction_type_id' => $data['transactionType'],
            ':user_id' => $_SESSION['user_id'],
        ]);

        return ['success' => true, 'message' => "Annonce créée avec succès."];
    }

    public function getPropertyTypes(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT id, name FROM propertyType ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTransactionTypes(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT id, name FROM transactionType ORDER BY name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
