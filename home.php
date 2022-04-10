<?php include 'templates/haut.php';?>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">MyAPP</h1>
            <p class="lead">Bienvenue <?php echo $_SESSION['login']; ?>.</p>
            <p>Nous somme le <?php echo date('d/m/Y'); ?></p>
        </div>
    </div>

<?php include 'templates/bas.php'; ?>