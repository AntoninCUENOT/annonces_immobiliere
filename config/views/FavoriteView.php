<?php

namespace Views;

class FavoriteView
{
    public function renderFavoritesPage(array $favorites): void
    {
        echo "<h2>Mes annonces favorites</h2>";

        if (empty($favorites)) {
            echo "<p>Vous n’avez aucune annonce en favori.</p>";
        } else {
            echo "<div class='favorites-list'>";
            foreach ($favorites as $annonce) {
                $this->renderCard($annonce);
            }
            echo "</div>";
        }
    }

    private function renderCard(array $annonce): void
    {
        echo '<div style="border: 1px solid #ccc; margin: 10px; padding: 10px; width: 300px;">';
        echo '<h3>' . htmlspecialchars($annonce['title']) . '</h3>';
        echo '<img src="./' . htmlspecialchars($annonce['image_url']) . '" alt="Image" style="width:100%; height:auto;">';
        echo '<p><strong>Prix:</strong> ' . number_format($annonce['price'], 0, ',', ' ') . ' €</p>';
        echo '<p><strong>Ville:</strong> ' . htmlspecialchars($annonce['city']) . '</p>';
        echo '<p>' . nl2br(htmlspecialchars($annonce['description'])) . '</p>';
        echo "<a href='/annonce/{$annonce['id']}'>Voir l’annonce</a>";

        echo '<form class="fav-form" action="?page=favorite_remove&id=' . $annonce['id'] . '" method="post">';
        echo '<button class="fav-btn" type="submit">❤️</button>';
        echo '</form>';

        echo '</div>';
    }
}
