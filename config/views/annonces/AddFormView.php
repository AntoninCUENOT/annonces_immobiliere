<?php

namespace App\Views\Annonces;

class AddFormView
{
    public function render(array $result = [], array $propertyTypes = [], array $transactionTypes = []): void
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

            <form method="post" enctype="multipart/form-data">
                <div>
                    <label for="image">Image</label>
                    <input type="file" name="image" accept="image/*" required>
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
                        <?php foreach ($transactionTypes as $type): ?>
                            <option value="<?= htmlspecialchars($type['id']) ?>">
                                <?= htmlspecialchars($type['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Type de bien</label>
                    <select name="propertyType" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($propertyTypes as $type): ?>
                            <option value="<?= htmlspecialchars($type['id']) ?>">
                                <?= htmlspecialchars($type['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Enregistrer</button>
            </form>

            <a href="?page=annonces" class="btn-retour">Retour aux annonces</a>
        </div>
<?php
    }
}
