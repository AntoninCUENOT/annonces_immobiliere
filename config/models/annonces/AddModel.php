<?php

namespace App\Models\Annonces;

require_once __DIR__ . '/../../database/Database.php';

use Config\Database\Database;
use PDO;

class AddModel
{
    public function validateForm(array $data): array
    {
        $requiredFields = ['title', 'price', 'city', 'description', 'transactionType', 'propertyType'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field] ?? ''))) {
                $errors[] = "Le champ $field est requis.";
            }
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Une image valide est requise.";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $db = Database::getConnection();

        try {
            $db->beginTransaction();

            // Étape 1 : Insertion de l’annonce sans image_url
            $stmt = $db->prepare("
            INSERT INTO listing (title, description, price, city, property_type_id, transaction_type_id, user_id)
            VALUES (:title, :description, :price, :city, :property_type_id, :transaction_type_id, :user_id)
        ");

            $stmt->execute([
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':price' => $data['price'],
                ':city' => $data['city'],
                ':property_type_id' => $data['propertyType'],
                ':transaction_type_id' => $data['transactionType'],
                ':user_id' => $_SESSION['user_id'],
            ]);

            $listingId = $db->lastInsertId();

            // Étape 2 : Upload réel de l’image
            $tmpName = $_FILES['image']['tmp_name'];
            $originalName = basename($_FILES['image']['name']);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                throw new \Exception("Format d’image non autorisé. Extensions autorisées : jpg, jpeg, png, gif.");
            }

            $safeName = uniqid() . '.' . $extension;

            $targetDir = __DIR__ . '/../../../public/annonces/' . $listingId;
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    throw new \Exception("Erreur lors de la création du dossier d'upload.");
                }
            }

            $targetPath = $targetDir . '/' . $safeName;
            if (!move_uploaded_file($tmpName, $targetPath)) {
                throw new \Exception("Erreur lors de l’upload de l’image.");
            }

            $relativePath = 'public/annonces/' . $listingId . '/' . $safeName;

            // Étape 3 : mise à jour de image_url
            $updateStmt = $db->prepare("UPDATE listing SET image_url = :image_url WHERE id = :id");
            $updateStmt->execute([
                ':image_url' => $relativePath,
                ':id' => $listingId
            ]);

            $db->commit();

            return ['success' => true, 'message' => "Annonce créée avec succès."];
        } catch (\Exception $e) {
            $db->rollBack();
            return ['success' => false, 'errors' => ["Erreur : " . $e->getMessage()]];
        }
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
