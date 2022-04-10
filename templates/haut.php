<?php session_start();
if(!isset($_SESSION['login'])){
    header('location:index.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Gestion des commandes</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="css/sidebars.css" rel="stylesheet">
</head>
<body>


<main>
    <h1 class="visually-hidden">Gestion des commandes</h1>


    <div class="flex-shrink-0 p-3 bg-white" style="width: 280px;">
        <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <img src="images/logo.jpg" width="50px"/>
            <span class="fs-5 fw-semibold">My App</span>
        </a>
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Clients
                </button>
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="AjouterClient.php" class="link-dark rounded">Ajouter</a></li>
                        <li><a href="ChercherClient.php" class="link-dark rounded">Chercher</a></li>
                        <li><a href="listerClient.php" class="link-dark rounded">Lister</a></li>
                        <li><a href="#" class="link-dark rounded">Exporter</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    Produits
                </button>
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="AjouterProduit.php" class="link-dark rounded">Ajouter</a></li>
                        <li><a href="#" class="link-dark rounded">Chercher</a></li>
                        <li><a href="listerProduit.php" class="link-dark rounded">Lister</a></li>
                        <li><a href="#" class="link-dark rounded">Exporter</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                    Commandes
                </button>
                <div class="collapse" id="orders-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="AjouterCommande.php" class="link-dark rounded">Ajouter</a></li>
                        <li><a href="ListerCommande.php" class="link-dark rounded">Afficher</a></li>

                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                    Outils
                </button>
                <div class="collapse" id="orders-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="Exportation.php" class="link-dark rounded">Export</a></li>
                        <li><a href="Importation.php" class="link-dark rounded">Import</a></li>
                        <li><a href="Courbes.php" class="link-dark rounded">Courbes</a></li>

                    </ul>
                </div>
            </li>

            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    Profil :
                    <button type="button" class="btn btn-warning"><?php echo $_SESSION['login']; ?></button>
                </button>
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="inc/quitter.php" class="link-dark rounded">Quitter</a></li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>

    <div class="b-example-divider"></div>

    <div class="container">
        <div class="m-4"></div>
