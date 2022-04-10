<?php include 'templates/haut.php';?>

    <div class="card">
        <h5 class="card-header">Ajouter un nouveau Produit</h5>
        <div class="card-body">

            <form action="inc/AjouterProduitAction.php" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-4">
                        <label class="form-check-label" for="exampleCheck1">LIBELLE</label>
                        <input type="text" class="form-control" name="LIBELLE" required>
                    </div>
                    <div class="col-4">
                        <label class="form-check-label" for="exampleCheck1">Prix</label>
                        <input type="text" class="form-control" name="PRIX" required>
                    </div>


                </div>

            <div class="m-2"></div>
                <div class="row">
                    <div class="col-4">
                        <label class="form-check-label" for="exampleCheck1">Nom</label>
                        <input type="file" class="form-control" name="PHOTO">
                    </div>
                    <div class="col-4">
                        <div class="m-3"></div>
                        <img  src="images/produit.JPG"  width="50px"/>
                    </div>
                </div>
                <div class="m-2"></div>
                <div class="row">
                    <div class="col-4">
                        <input type="submit" class="btn btn-primary"  value="Ajouter">
                    </div>

                </div>

            </form>

        </div>

    </div>
<div class="m-2"></div>

<?php
if(isset($_GET['message']))
    if($_GET['type'] == 'success'){
        ?><div class="alert alert-success"><?php echo $_GET['message']; ?></div> <?php
    }else{

        ?><div class="alert alert-danger"><?php echo $_GET['message']; ?></div> <?php
    }


?>



<?php include 'templates/bas.php'; ?>