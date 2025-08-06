<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - <?php echo $site_slogan; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style/style.css">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <h1><i class="fas fa-home"></i> <?php echo $site_name; ?></h1>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="?page=''">Accueil</a></li>
                    <li><a href="#acheter">Acheter</a></li>
                    <li><a href="#louer">Louer</a></li>
                    <li><a href="#vendre">Vendre</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <div class="nav-actions">
                <?php if(isset($_SESSION['mail'])) { ?>
                    <a href="?page=logout" class="btn btn-secondary">Deconnexion</a>
                    <a href="?page=add" class="btn btn-add">Add</a>
                <?php } else { ?>
                    <a href="?page=login" class="btn btn-secondary">Connexion</a>
                    <a href="?page=register" class="btn btn-primary">Inscription</a>
                <?php } ?>
            </div>
        </div>
    </header>