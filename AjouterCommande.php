<?php include 'templates/haut.php';?>
<?php
include 'inc/DB.php';
$mysql= new DB();
$c= $mysql->cnx;
$sqlClient = "SELECT * FROM `clients`";
$reponseClient = $c->query($sqlClient)->fetchAll();

$sqlProduit = "SELECT * FROM `produits`";
$reponseProduit = $c->query($sqlProduit)->fetchAll();
//var_dump($reponse);
?>
    <div class="card">
        <h5 class="card-header">Ajouter une commande</h5>
        <div class="card-body">

            <form action="AjouterCommandeAction.php" method="post" >
                <div class="row">
                    <div class="col-4">
                        <label class="form-check-label" for="exampleCheck1">Client</label>
                        <select type="text" class="form-control" name="CLIENT_ID" required>
                            <?php foreach ($reponseClient as $client){?>
                            <option value="<?php echo $client['ID']; ?>"><?php echo $client['NOM']." ".$client['PRENOM']; ?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="col-4">
                        <div class="m-4"></div>
                        <button  type="button" class="btn btn-warning" > + Ligne</button>
                        <a href="AjouterCommande.php"  class="btn btn-success" > &#128472; Actualiser</a>
                    </div>


                </div>

                <div class="m-2"></div>
                <div class="row ligne_commande">
                    <div class="col-4">
                        <label class="form-check-label" for="exampleCheck1">Produit</label>
                        <select type="text" class="form-control" name="PRODUIT_ID[]" required>
                            <?php foreach ($reponseProduit as $produit){?>
                                <option value="<?php echo $produit['ID']; ?>"><?php echo $produit['LIBELLE']; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-check-label" for="exampleCheck1" >Qte</label>
                        <input type="tel" class="form-control" name="QTE[]" required>
                    </div>

                    <div class="col-4">
                        <div class="m-4"></div>
                        <button  type="button" class="btn btn-info" onclick="$(this).parent().parent().remove()">Supprimer la ligne </button>
                    </div>

                </div>


                <div class="m-4"></div>
                <div class="row">
                    <div class="col-4">
                        <input type="submit" class="btn btn-primary"  value="Valider la commande">
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