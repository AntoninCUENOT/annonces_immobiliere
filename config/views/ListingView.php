<?php

namespace Config\Views;

class ListingView
{
    public function render(array $listings): void
    {
        echo '<h2 style="text-align:center;">Liste des ' . $_GET['page'] . '</h2>';
        echo '<div style="display: flex; flex-wrap: wrap; justify-content: center;">';

        foreach ($listings as $listing) {
            echo '<div style="border: 1px solid #ccc; margin: 10px; padding: 10px; width: 300px;">';
            echo '<h3>' . htmlspecialchars($listing['title']) . '</h3>';
            echo '<img src="' . htmlspecialchars($listing['image_url']) . '" alt="Image" style="width:100%; height:auto;">';
            echo '<p><strong>Prix:</strong> ' . number_format($listing['price'], 0, ',', ' ') . ' €</p>';
            echo '<p><strong>Ville:</strong> ' . htmlspecialchars($listing['city']) . '</p>';
            echo '<p><strong>Type de bien:</strong> ' . htmlspecialchars($listing['property_type']) . '</p>';
            echo '<p><strong>Transaction:</strong> ' . htmlspecialchars($listing['transaction_type']) . '</p>';
            echo '<p>' . nl2br(htmlspecialchars($listing['description'])) . '</p>';
            echo '</div>';
        }

        echo '</div>';
    }

    public function renderSeparated(array $maisons, array $appartements): void
    {
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
        echo '<div style="border: 1px solid #ccc; margin: 10px; padding: 10px; width: 300px;">';
        echo '<h3>' . htmlspecialchars($listing['title']) . '</h3>';
        echo '<img src="./' . htmlspecialchars($listing['image_url']) . '" alt="Image" style="width:100%; height:auto;">';
        echo '<p><strong>Prix:</strong> ' . number_format($listing['price'], 0, ',', ' ') . ' €</p>';
        echo '<p><strong>Ville:</strong> ' . htmlspecialchars($listing['city']) . '</p>';
        echo '<p><strong>Type de bien:</strong> ' . htmlspecialchars($listing['property_type']) . '</p>';
        echo '<p><strong>Transaction:</strong> ' . htmlspecialchars($listing['transaction_type']) . '</p>';
        echo '<p>' . nl2br(htmlspecialchars($listing['description'])) . '</p>';
        echo '</div>';
    }
}
