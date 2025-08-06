<?php

namespace App\Views;

class AddFormView
{
    public function render(array $result = []): void
    {
        ?>
        <div class="container">
            <h2>Créer une annonce</h2>

            <?php if (isset($result['success']) && $result['success']): ?>
                <div class="alert alert-success"><?= $result['message'] ?></div>
            <?php elseif (!empty($result['errors'])): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($result['errors'] as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post">
                <div>
                    <label>Image URL</label>
                    <input type="text" name="image" required>
                </div>
                <div>
                    <label>Titre</label>
                    <input type="text" name="title" required>
                </div>
                <div>
                    <label>Prix</label>
                    <input type="number" name="price" required>
                </div>
                <div>
                    <label>Ville</label>
                    <input type="text" name="city" required>
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="description" required></textarea>
                </div>
                <div>
                    <label>Type de transaction</label>
                    <select name="transactionType" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="Rent">Location</option>
                        <option value="Sale">Vente</option>
                    </select>
                </div>
                <div>
                    <label>Type de bien</label>
                    <select name="propertyType" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="House">Maison</option>
                        <option value="Apartment">Appartement</option>
                    </select>
                </div>
                <button type="submit">Enregistrer</button>
            </form>

            <a href="./">Retour à l'accueil</a>
        </div>
        <?php
    }
}
