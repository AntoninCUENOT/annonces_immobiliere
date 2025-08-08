<?php

namespace Views;

class EditAnnonceView
{
    public function render(array $annonce, array $propertyTypes, array $transactionTypes, ?string $message): void
    {
?>
        <div class="container">
            <h2>Modifier une annonce</h2>

            <?php if ($message): ?>
                <p style="color: red;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <div>
                    <label>Titre</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($annonce['title']) ?>" required><br>
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="description" required><?= htmlspecialchars($annonce['description']) ?></textarea><br>
                </div>
                <div>
                    <label>Prix</label>
                    <input type="number" name="price" value="<?= htmlspecialchars($annonce['price']) ?>" required><br>
                </div>
                <div>
                    <label>Ville</label>
                    <input type="text" name="city" value="<?= htmlspecialchars($annonce['city']) ?>" required><br>
                </div>

                <div>
                    <label>Image actuelle :</label><br>
                    <?php if ($annonce['image_url']): ?>
                        <img src="<?= htmlspecialchars($annonce['image_url']) ?>" alt="Image actuelle" style="max-width: 200px;"><br>
                    <?php endif; ?>

                    <label>Changer l'image :</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif"><br>
                </div>

                <div>
                    <label>Type de bien</label>
                    <select name="property_type_id" required>
                        <?php foreach ($propertyTypes as $type): ?>
                            <option value="<?= $type['id'] ?>" <?= $type['id'] == $annonce['property_type_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($type['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>
                </div>


                <div>

                    <label>Type de transaction</label>
                    <select name="transaction_type_id" required>
                        <?php foreach ($transactionTypes as $type): ?>
                            <option value="<?= $type['id'] ?>" <?= $type['id'] == $annonce['transaction_type_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($type['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>
                </div>

                <button type="submit">Enregistrer</button>
            </form>
            <a href="?page=annonces" class="btn-retour">Retour aux annonces</a>
        </div>
<?php
    }
}
