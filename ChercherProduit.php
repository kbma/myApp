<?php include 'templates/haut.php';
include 'inc/DB.php';
$DB = new DB();
$debut =$_GET['debut']??$_GET['debut']??0;
$nbre =$_GET['nbre']??$_GET['nbre']??5;

$where="";

if(isset($_POST['MC'])){
    if(!empty($_POST['MC'])){
        $where=" where LIBELLE like '%".$_POST['MC']."%' or PRIX like '%".$_POST['MC']."%'";
        $_SESSION['paginate']="&MC=".$_POST['MC'];
    }
}

if(isset($_GET['MC'])){
    if(!empty($_GET['MC'])){
        $where=" where LIBELLE like '%".$_GET['MC']."%' or PRIX like '%".$_GET['MC']."%'";
        $_SESSION['paginate']="&MC=".$_GET['MC'];
    }
}
if(!isset($_SESSION['paginate'])){
    $_SESSION['paginate']="";
}

$sql= "select * from produits $where limit ".$debut.",".$nbre;
$produits= $DB->cnx->query($sql);

#Calculer le nbre des page
$sqlPage= "select * from produits $where";
$reponsePAge= $DB->cnx->query($sqlPage)->fetchAll();
$nbrePage =ceil(count($reponsePAge)/$nbre);

$PageCourante=$_GET['PageCourante']??$_GET['PageCourante']??1;

?>


    <div class="card">
        <div class="card-header"><h5>Chercher produits</h5></div>
        <div class="card-body">
            <!-------le formulaire de recherche---------->
            <form class="row g-3" action="chercherProduit.php" method="post">
                <div class="col-auto">
                    Tapez un mot clé
                </div>
                <div class="col-auto">

                    <input type="text" class="form-control" name="MC">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Chercher</button>
                </div>
            </form>
            <!-------Fin du formulaire de recherche---------->


            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Libellé</th>

                    <th scope="col">Prix</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($produits as $produit){?>
                    <tr>
                        <th scope="row"><?php echo $produit['ID']; ?></th>
                        <td><img src="<?php if($produit['PHOTO']==""){ echo "images/inconnu.jpg"; } else{ echo $produit['PHOTO']; }; ?>"  width="50px"/></td>
                        <td><?php echo $produit['LIBELLE']; ?></td>
                        <td><?php echo $produit['PRIX']; ?></td>
                        <td>
                            <!-----Modification ----->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModifierProduit<?php echo $produit['ID'];?>">Modifier</button>
                            <!-- Modal -->
                            <div class="modal fade" id="ModifierProduit<?php echo $produit['ID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form action="updateProduitAction.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?php echo $produit['ID']; ?>" name="ID"/>
                                            <input type="hidden" value="<?php echo $produit['PHOTO']; ?>" name="PHOTO_OLD"/>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modifier le produit: <?php echo $produit['LIBELLE'];?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label class="form-label">Libellé</label>
                                                        <input type="text" name="LIBELLE" class="form-control" value="<?php echo $produit['LIBELLE'];?>" required>
                                                    </div>

                                                    <div class="col-4">
                                                        <label class="form-label">Prix</label>
                                                        <input type="text" name="PRIX" class="form-control" value="<?php echo $produit['PRIX'];?>"required>
                                                    </div>


                                                </div>

                                                <div class="m-2"></div>
                                                <div class="row">
                                                    <div class="col-9">
                                                        <input type="file" name="PHOTO" class="form-control">
                                                    </div>
                                                    <div class="col-3">
                                                        <img src="<?php echo $produit['PHOTO'];?>" width="50px"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <input type="submit" class="btn btn-primary" value="Enregistrer la modification"/>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-----Suppression ----->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#SupprimerProduit<?php echo $produit['ID'];?>">Supprimer</button>
                            <!-- Modal -->
                            <div class="modal fade" id="SupprimerProduit<?php echo $produit['ID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form action="DeleteClientAction.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?php echo $produit['ID']; ?>" name="ID"/>
                                            <input type="hidden" value="<?php echo $produit['PHOTO']; ?>" name="PHOTO"/>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Supprimer le produit: <?php echo $produit['LIBELLE'];?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <input type="submit" class="btn btn-danger" value="Supprimer le produit"/>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>



                        </td>
                    </tr>

                <?php }?>
                </tbody>
            </table>



        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">

                <?php
                if($PageCourante!=1){
                    ?>  <li class="page-item"><a class="page-link" href="chercherProduit.php?PageCourante=<?php echo $PageCourante-1;?><?php echo $_SESSION['paginate']; ?>&debut=<?php echo $debut-$nbre;?>">Précédent</a></li><?php
                }
                ?>

                <?php for($i=1; $i<= $nbrePage; $i++){?>
                    <li class="page-item <?php if($PageCourante==$i){echo "active"; }?>"><a class="page-link" href="chercherProduit.php?PageCourante=<?php echo $i;?><?php echo $_SESSION['paginate']; ?>&debut=<?php echo $nbre*($i-1);?>"><?php echo $i; ?></a></li>
                <?php }?>

                <?php
                if($PageCourante!=$nbrePage){
                    ?>
                    <li class="page-item"><a class="page-link" href="chercherProduit.php?PageCourante=<?php echo $PageCourante+1;?><?php echo $_SESSION['paginate']; ?>&debut=<?php echo $debut+$nbre;?>">Suivant</a></li>
                    <?php
                }
                ?>

            </ul>
        </nav>

        <?php
        if(isset($_GET['message'])){
            if($_GET['type']=='succes'){
                ?>
                <div class="alert-success">
                    <?php echo $_GET['message']; ?>
                </div>
                <?php

            }else{
                ?>
                <div class="alert-danger">
                    <?php echo $_GET['message']; ?>
                </div>
                <?php
            }
        }

        ?>

    </div>

<?php include 'templates/bas.php'; ?>