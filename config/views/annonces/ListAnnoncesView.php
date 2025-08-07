<?php

namespace Views\Annonces;

class ListAnnoncesView
{
    public function render(array $annonces, string $role): void
    {
        echo '<h1 style="text-align:center;">Liste des annonces</h1>';

        if (in_array($role, ['admin', 'agent'])) {
            echo '<a href="?page=add" style="margin-left:1rem;" class="btn btn-add">Ajouter une annonce</a>';
        }

        if (empty($annonces)) {
            echo '<p>Aucune annonce disponible.</p>';
            return;
        }

        echo '<table class="annonce-table">';
        echo '<thead><tr><th>Titre</th><th>Prix</th><th>Date</th><th>Actions</th></tr></thead>';
        echo '<tbody>';

        foreach ($annonces as $annonce) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($annonce['title']) . '</td>';
            echo '<td>' . htmlspecialchars($annonce['price']) . ' €</td>';
            echo '<td>' . htmlspecialchars($annonce['created_at']) . '</td>';
            echo '<td>';

            // Seuls admin OU agent propriétaire peuvent modifier/supprimer
            if (
                $role === 'admin' ||
                ($role === 'agent' && $annonce['user_id'] == $_SESSION['user_id'])
            ) {
                echo '<a href="?page=edit&id=' . $annonce['id'] . '" class="btn btn-warning">Modifier</a> ';
                echo '<a href="?page=delete&id=' . $annonce['id'] . '" class="btn btn-danger" onclick="return confirm(\'Supprimer cette annonce ?\')">Supprimer</a>';
            }

            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
}
