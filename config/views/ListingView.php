<?php

namespace Config\Views;

require_once __DIR__ . '/../models/FavoriteModel.php';

class ListingView
{
    public function render(array $listings, string $pageType, int $currentPage, int $totalPages): void
    {
        echo '<h2 style="text-align:center;">Liste des ' . htmlspecialchars($pageType) . '</h2>';

        $this->renderSearchForm($pageType, $_GET, $this->getPropertyTypes(), $this->getTransactionTypes());

        echo '<div style="display: flex; flex-wrap: wrap; justify-content: center;">';
        foreach ($listings as $listing) {
            $this->renderCard($listing);
        }
        echo '</div>';

        if ($totalPages > 1) {
            echo '<div style="text-align: center; margin-top: 20px;">';

            if ($currentPage > 1) {
                $prevPage = $currentPage - 1;
                echo '<a href="?page=' . urlencode($pageType) . '&pages=' . $prevPage . '" style="margin-right:10px;">&laquo; Précédent</a>';
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i === $currentPage) {
                    echo '<strong style="margin: 0 5px; color: red;">' . $i . '</strong>';
                } else {
                    echo '<a href="?page=' . urlencode($pageType) . '&pages=' . $i . '" style="margin: 0 5px;">' . $i . '</a>';
                }
            }

            if ($currentPage < $totalPages) {
                $nextPage = $currentPage + 1;
                echo '<a href="?page=' . urlencode($pageType) . '&pages=' . $nextPage . '" style="margin-left:10px;">Suivant &raquo;</a>';
            }

            echo '</div>';
        }
    }

    public function renderSeparated(array $maisons, array $appartements, array $filters = []): void
    {
        $this->renderHomeSearchForm($filters, $this->getTransactionTypes());

        echo '<a href="?page=Maisons"><h2 style="text-align:center;">Maisons</h2></a>';
        echo '<div style="display: flex; flex-wrap: wrap; justify-content: center;">';
        foreach ($maisons as $listing) {
            $this->renderCard($listing);
        }
        echo '</div>';

        echo '<a href="?page=Appartements"><h2 style="text-align:center; margin-top: 40px;">Appartements</h2></a>';
        echo '<div style="display: flex; flex-wrap: wrap; justify-content: center;">';
        foreach ($appartements as $listing) {
            $this->renderCard($listing);
        }
        echo '</div>';
    }

    private function renderCard(array $listing): void
    {
        $isFavorite = false;

        if (isset($_SESSION['user_id'])) {
            $favoriteModel = new \Models\FavoriteModel();
            $isFavorite = $favoriteModel->isFavorite($_SESSION['user_id'], $listing['id']);
        }

        echo '<div style="border: 1px solid #ccc; margin: 10px; padding: 10px; width: 300px;">';
        echo '<h3>' . htmlspecialchars($listing['title']) . '</h3>';
        echo '<img src="' . htmlspecialchars($listing['image_url']) . '" alt="Image" style="width:100%; height:auto;">';
        echo '<p><strong>Prix:</strong> ' . number_format($listing['price'], 0, ',', ' ') . ' €</p>';
        echo '<p><strong>Ville:</strong> ' . htmlspecialchars($listing['city']) . '</p>';
        echo '<p><strong>Type de bien:</strong> ' . htmlspecialchars($listing['property_type']) . '</p>';
        echo '<p><strong>Transaction:</strong> ' . htmlspecialchars($listing['transaction_type']) . '</p>';
        echo '<p>' . nl2br(htmlspecialchars($listing['description'])) . '</p>';

        if (isset($_SESSION['user_id'])) {
            if ($isFavorite) {
                echo '<form class="fav-form" action="?page=favorite_remove&id=' . $listing['id'] . '" method="post">';
                echo '<button class="fav-btn" type="submit">❤️</button>';
                echo '</form>';
            } else {
                echo '<form class="fav-form" action="?page=favorite_add&id=' . $listing['id'] . '" method="post">';
                echo '<button class="fav-btn" type="submit">🤍</button>';
                echo '</form>';
            }
        }

        echo '</div>';
    }

    private function renderSearchForm(string $pageType, array $filters, array $propertyTypes, array $transactionTypes): void
    {
        echo '<form method="GET" style="margin-bottom: 20px; text-align:center;">';
        echo '<input type="hidden" name="page" value="' . htmlspecialchars($pageType) . '" />';

        echo 'Ville: <input type="text" name="ville" value="' . htmlspecialchars($filters['ville'] ?? '') . '" /> ';
        echo 'Prix maximum: <input type="number" name="prix_max" value="' . htmlspecialchars($filters['prix_max'] ?? '') . '" /> ';

        echo 'Type de transaction: <select name="transaction_type_id">';
        echo '<option value="">--Toutes--</option>';
        foreach ($transactionTypes as $type) {
            $selected = (isset($filters['transaction_type_id']) && $filters['transaction_type_id'] == $type['id']) ? 'selected' : '';
            echo '<option value="' . $type['id'] . '" ' . $selected . '>' . htmlspecialchars($type['name']) . '</option>';
        }
        echo '</select> ';

        echo '<button type="submit">Rechercher</button>';
        echo '<a href="/?page=' . htmlspecialchars($_GET['page'] ?? '') . '" class="btn btn-primary">Réinitialiser</a>';
        echo '</form>';
    }

    private function renderHomeSearchForm(array $filters, array $transactionTypes): void
    {
        echo '<form method="GET" style="margin-bottom: 20px; text-align:center;">';

        echo 'Ville: <input type="text" name="ville" value="' . htmlspecialchars($filters['ville'] ?? '') . '" /> ';
        echo 'Prix maximum: <input type="number" name="prix_max" value="' . htmlspecialchars($filters['prix_max'] ?? '') . '" /> ';

        echo 'Type de transaction: <select name="transaction_type_id">';
        echo '<option value="">--Toutes--</option>';
        foreach ($transactionTypes as $type) {
            $selected = (isset($filters['transaction_type_id']) && $filters['transaction_type_id'] == $type['id']) ? 'selected' : '';
            echo '<option value="' . $type['id'] . '" ' . $selected . '>' . htmlspecialchars($type['name']) . '</option>';
        }
        echo '</select> ';

        echo '<button type="submit">Rechercher</button>';
        echo '<a href="/" class="btn btn-primary">Réinitialiser</a>';
        echo '</form>';
    }

    private function getPropertyTypes(): array
    {
        $db = \Config\Database\Database::getConnection();
        $stmt = $db->query("SELECT id, name FROM propertyType");
        return $stmt->fetchAll();
    }

    private function getTransactionTypes(): array
    {
        $db = \Config\Database\Database::getConnection();
        $stmt = $db->query("SELECT id, name FROM transactionType");
        return $stmt->fetchAll();
    }
}
