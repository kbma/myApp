<?php
include 'inc\DB.php';

    $c = new DB();

    //Last Client
    $sql="SELECT * FROM clients ORDER BY ID DESC LIMIT 1 ";
    $reponse = $c->cnx->query($sql);
    $infos = $reponse->fetch();
    $diplay_client=false;
    if ($infos >0){
                $id_client=$infos['ID'];
                $nom_client=$infos['NOM'];
                $prenom_client=$infos['PRENOM'];
                $photo_client=$infos['PHOTO'];
                $tel_client=$infos['TEL'];
                $diplay_client=true;
    }

    //Last produit
    $sql2="SELECT * FROM produits ORDER BY ID DESC LIMIT 1 ";
    $reponse2 = $c->cnx->query($sql2);
    $infos2 = $reponse2->fetch();
    $diplay_produit=false;
    if ($infos2 >0){
        $id_produit=$infos2['ID'];
        $libelle_produit=$infos2['LIBELLE'];
        $prix_produit=$infos2['PRIX'];
        $photo_produit=$infos2['PHOTO'];
        $diplay_produit=true;
    }

    //nbre clients
    $sql3="SELECT *  FROM clients ";
    $reponse3 = $c->cnx->query($sql3);
    $infos3 = $reponse3->fetchAll();

    //nbre produits
    $sql4="SELECT *  FROM produits ";
    $reponse4 = $c->cnx->query($sql4);
    $infos4 = $reponse4->fetchAll();

    //nbre commandes
    $sql5="SELECT *  FROM commandes ";
    $reponse5 = $c->cnx->query($sql5);
    $infos5 = $reponse5->fetchAll();

?>

<?php include 'templates/haut.php';?>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">

            <p class="display-6">Bienvenue <?php echo $_SESSION['login']; ?></p>
            <p>Nous somme le <?php echo date('d/m/Y'); ?></p>
        </div>
    </div>
<div class="container">

    <div class="row row-cols-1 row-cols-md-2 g-4">

       <?php if($diplay_client){?>
        <div class="col">
            <h4>Dernier client ajouté</h4>
            <div class="card">
                <img src="<?php echo $photo_client; ?>" width="50px" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $nom_client; ?> <?php echo $prenom_client; ?></h5>
                    <p class="card-text"><?php echo $nom_client; ?> <?php echo $prenom_client; ?>  <?php echo $tel_client; ?></p>
                </div>
            </div>
        </div>
        <?php }?>

    <?php if($diplay_produit){?>
        <div class="col">
            <h4>Dernier produit ajouté</h4>
            <div class="card">
                <img src="<?php echo $photo_produit; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $libelle_produit; ?> </h5>
                    <p class="card-text"><?php echo $libelle_produit; ?> <?php echo $prix_produit; ?> Euro</p>
                </div>
            </div>
        </div>
        <?php }?>

    </div>
<div class="m-4"></div>



    <div class="row">
        <div class="col-6">
             <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nombre des clients</div>
                        <?php echo $nom_client; ?> <?php echo $prenom_client; ?>
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo count($infos3); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nombre des produits</div>
                        <?php echo $libelle_produit; ?>
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo count($infos4); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nombre des commandes</div>
                        Content for list item
                    </div>
                    <span class="badge bg-primary rounded-pill"><?php echo count($infos5); ?></span>
                </li>
            </ol>
        </div>


            <div class="col-6">

                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Subheading</div>
                            Content for list item
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Subheading</div>
                            Content for list item
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Subheading</div>
                            Content for list item
                        </div>
                        <span class="badge bg-primary rounded-pill">14</span>
                    </li>
                </ol>
            </div>

    </div>
</div>

<?php include 'templates/bas.php'; ?>