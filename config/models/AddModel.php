<?php

namespace App\Models;

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

        if (empty($errors)) {
            return ['success' => true, 'message' => 'Annonce soumise avec succès (non enregistrée).'];
        }

        return ['success' => false, 'errors' => $errors];
    }
}
