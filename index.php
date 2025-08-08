<?php
session_start();

// Configuration de base
$site_name = "Find My Dream Home";
$site_slogan = "Trouvez votre bien immobilier idéal";

// Tableau des maisons
// $maisons = [
//     [
//         'id' => 1,
//         'title' => 'Maison familiale avec jardin',
//         'price' => 680000,
//         'location' => 'Neuilly-sur-Seine',
//         'surface' => 120,
//         'rooms' => 5,
//         'bedrooms' => 4,
//         'bathrooms' => 2,
//         'garage' => true,
//         'garden' => true,
//         'description' => 'Belle maison familiale dans quartier résidentiel calme',
//         'image' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=400&h=300&fit=crop'
//     ],
//     [
//         'id' => 2,
//         'title' => 'Villa moderne avec piscine',
//         'price' => 950000,
//         'location' => 'Cannes',
//         'surface' => 180,
//         'rooms' => 7,
//         'bedrooms' => 5,
//         'bathrooms' => 3,
//         'garage' => true,
//         'garden' => true,
//         'description' => 'Villa contemporaine avec vue mer et piscine privée',
//         'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=300&fit=crop'
//     ],
//     [
//         'id' => 3,
//         'title' => 'Maison de ville rénovée',
//         'price' => 520000,
//         'location' => 'Bordeaux Centre',
//         'surface' => 95,
//         'rooms' => 4,
//         'bedrooms' => 3,
//         'bathrooms' => 2,
//         'garage' => false,
//         'garden' => false,
//         'description' => 'Charmante maison de ville entièrement rénovée',
//         'image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=400&h=300&fit=crop'
//     ]
// ];

// // Tableau des appartements
// $appartements = [
//     [
//         'id' => 4,
//         'title' => 'Appartement moderne 3 pièces',
//         'price' => 450000,
//         'location' => 'Paris 15e',
//         'surface' => 75,
//         'rooms' => 3,
//         'bedrooms' => 2,
//         'bathrooms' => 1,
//         'balcon' => true,
//         'ascenseur' => true,
//         'parking' => true,
//         'description' => 'Appartement lumineux avec balcon et vue dégagée',
//         'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&h=300&fit=crop'
//     ],
//     [
//         'id' => 5,
//         'title' => 'Penthouse avec terrasse',
//         'price' => 780000,
//         'location' => 'Lyon 6e',
//         'surface' => 110,
//         'rooms' => 4,
//         'bedrooms' => 3,
//         'bathrooms' => 2,
//         'balcon' => false,
//         'ascenseur' => true,
//         'parking' => true,
//         'description' => 'Magnifique penthouse avec grande terrasse panoramique',
//         'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=400&h=300&fit=crop'
//     ],
//     [
//         'id' => 6,
//         'title' => 'Studio lumineux centre-ville',
//         'price' => 280000,
//         'location' => 'Marseille 1er',
//         'surface' => 35,
//         'rooms' => 1,
//         'bedrooms' => 0,
//         'bathrooms' => 1,
//         'balcon' => false,
//         'ascenseur' => false,
//         'parking' => false,
//         'description' => 'Studio optimisé en plein cœur de la ville',
//         'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&h=300&fit=crop'
//     ]
// ];

// // Fusionner les deux tableaux pour les statistiques
// $all_properties = array_merge($maisons, $appartements);

// // Statistiques du site (calculées dynamiquement)
// $stats = [
//     'total_properties' => count($all_properties) * 425, // Simulation d'une base plus large
//     'cities' => 156,
//     'satisfied_clients' => 8942
// ];

require_once "./templates/header.php";

// Définir la page demandée, par défaut "login"
$page = $_GET['page'] ?? '';


switch ($page) {
    case 'login':
        if (isset($_SESSION['user'])) {
            header("Location: ?page=dashboard");
        } else {
            include_once "./config/pages/login.php";
        }

        break;

    case 'register':
        include_once "./config/pages/register.php";
        break;

    case 'annonces':
        include_once './config/pages/annonces/list.php';
        break;

    case 'delete':
        include_once "./config/pages/annonces/delete.php";
        break;

    case 'edit':
        include_once "./config/pages/annonces/edit.php";
        break;

    case 'add':
        include_once "./config/pages/annonces/add.php";
        break;

    case 'favorite':
        include_once './config/pages/favorite/favorite.php';
        break;

    case 'favorite_add':
        include_once './config/pages/favorite/favoriteAdd.php';
        break;

    case 'favorite_remove':
        include_once './config/pages/favorite/favoriteRemove.php';
        break;

    case 'logout':
        session_destroy();
        header("Location: ?page=dashboard");
        exit();

    default:
        include_once "./config/pages/listings.php";
        break;
}

require_once "./templates/footer.php";
