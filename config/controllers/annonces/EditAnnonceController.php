<?php

namespace Controllers;

require_once __DIR__ . "/../Auth.php";

use Models\EditAnnonceModel;
use Config\Auth;
use Exception;

class EditAnnonceController
{
    public function handleRequest(): void
    {
        if (!isset($_SESSION['user'], $_SESSION['role'], $_SESSION['user_id'])) {
            $_SESSION['error'] = "Accès refusé.";
            header("Location: ?page=login");
            exit();
        }

        Auth::checkAccess(['agent', 'admin']);

        $role = $_SESSION['role'];
        $userId = $_SESSION['user_id'];

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID invalide.";
            header("Location: ?page=annonces");
            exit();
        }

        $annonceId = (int)$_GET['id'];
        $model = new EditAnnonceModel();
        $annonce = $model->getAnnonceById($annonceId);

        if (!$annonce) {
            $_SESSION['error'] = "Annonce introuvable.";
            header("Location: ?page=annonces");
            exit();
        }

        if ($role !== 'admin' && $annonce['user_id'] != $userId) {
            $_SESSION['error'] = "Vous n'avez pas les droits pour modifier cette annonce.";
            header("Location: ?page=annonces");
            exit();
        }

        $message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = $model->getPDO(); // Accès direct au PDO pour la transaction
            try {
                $db->beginTransaction();

                $data = [
                    'title' => $_POST['title'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'price' => $_POST['price'] ?? '',
                    'city' => $_POST['city'] ?? '',
                    'image_url' => $annonce['image_url'], // par défaut
                    'property_type_id' => $_POST['property_type_id'] ?? '',
                    'transaction_type_id' => $_POST['transaction_type_id'] ?? ''
                ];

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['image']['tmp_name'];
                    $fileName = basename($_FILES['image']['name']);
                    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    if (!in_array($extension, $allowedExtensions)) {
                        throw new Exception("Format d’image non autorisé.");
                    }

                    $uploadDir = __DIR__ . "/../../../public/annonces/{$annonceId}/";
                    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                        throw new Exception("Erreur lors de la création du dossier d’upload.");
                    }

                    $destination = $uploadDir . $fileName;

                    if (!move_uploaded_file($fileTmpPath, $destination)) {
                        throw new Exception("Échec de l’upload de l’image.");
                    }

                    $ancienneImagePath = __DIR__ . "/../../../" . $annonce['image_url'];
                    if (is_file($ancienneImagePath) && $annonce['image_url'] !== "annonces/{$annonceId}/{$fileName}") {
                        unlink($ancienneImagePath);
                    }

                    $data['image_url'] = "public/annonces/{$annonceId}/{$fileName}";
                }

                $success = $model->updateAnnonce($annonceId, $data);
                if (!$success) {
                    throw new Exception("Erreur lors de la mise à jour de l’annonce.");
                }

                $db->commit();
                $_SESSION['success'] = "Annonce mise à jour avec succès.";
                header("Location: ?page=annonces");
                exit();
            } catch (Exception $e) {
                $db->rollBack();
                $message = $e->getMessage();
            }
        }

        $propertyTypes = $model->getPropertyTypes();
        $transactionTypes = $model->getTransactionTypes();

        require_once __DIR__ . '/../../views/annonces/EditAnnonceView.php';
        $view = new \Views\EditAnnonceView();
        $view->render($annonce, $propertyTypes, $transactionTypes, $message);
    }
}
