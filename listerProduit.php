<?php include 'templates/haut.php';?>
<?php
include 'inc/DB.php';
$mysql= new DB();
$c= $mysql->cnx;
$debut= $_GET['debut']??$_GET['debut']??0;
$nbre= $_GET['nbre']??$_GET['nbre']??5;
$PageCourante= $_GET['pagecourante']??$_GET['pagecourante']??1;

$sql = "SELECT * FROM `produits` order by ID DESC limit ".$debut.",".$nbre;
$reponse = $c->query($sql);

$sqlPage = "SELECT * FROM `produits`";
$reponsePage = $c->query($sqlPage)->fetchAll();
$nbrePages=ceil(count($reponsePage)/$nbre,);


?>
    <div class="card">
        <h5 class="card-header">La liste des produits:  </h5>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Libelle</th>
                    <th scope="col">Prix</th>

                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reponse as $produit) { ?>
                <tr>
                    <th scope="row"><?php echo $produit['ID']; ?></th>
                    <td><img src="<?php echo $produit['PHOTO']; ?>" width="50px" /></td>
                    <td><?php echo $produit['LIBELLE']; ?></td>
                    <td><?php echo $produit['PRIX']; ?></td>

                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $produit['ID']; ?>">
                            Modifier
                        </button>

                        <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo $produit['ID']; ?>">
                            Supprimer
                        </button>
                        <!-- Modal Edit-->
                        <form action="inc/UpdateProduitAction.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $produit['ID']; ?>" name="ID"/>
                            <input type="hidden" value="<?php echo $produit['PHOTO']; ?>" name="PHOTO_OLD"/>
                            <div class="modal fade" id="exampleModal<?php echo $produit['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modification du produit : <?php echo $produit['LIBELLE']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="form-label">Nom</label>
                                                    <input type="text" class="form-control" name="LIBELLE" value="<?php echo $produit['LIBELLE']; ?>">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Prénom</label>
                                                    <input type="text" class="form-control" name="PRIX" value="<?php echo $produit['PRIX']; ?>">
                                                </div>

                                            </div>
                                            <div class="m-3"></div>
                                            <div class="row">
                                                <div class="col-9">
                                                    <input type="file" class="form-control" name="PHOTO">
                                                </div>
                                                <div class="col-3">
                                                    <img src="<?php echo $produit['PHOTO']; ?>" width="50px"/>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <input type="submit" class="btn btn-primary" value="Enregistrer"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Modal delete-->
                        <form action="DeleteProduitAction.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $produit['ID']; ?>" name="ID"/>
                            <input type="hidden" value="<?php echo $produit['PHOTO']; ?>" name="PHOTO_OLD"/>
                            <div class="modal fade" id="exampleModalDelete<?php echo $produit['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalDelete">Supprimer le client : <?php echo $produit['LIBELLE']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-3">
                                                    <img src="<?php echo $produit['PHOTO']; ?>" width="50px"/>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <input type="submit" class="btn btn-danger" value="Supprimer"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </td>
                </tr>
                <?php }?>

                </tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if($PageCourante != 1){
                        ?><li class="page-item"><a class="page-link" href="listerProduit.php?pagecourante=<?php echo $PageCourante-1;?>&debut=<?php echo $debut-$nbre; ?>">Précédent</a></li><?php
                    }
                    ?>
                    <?php for($i=1; $i<=$nbrePages; $i++){?>
                        <li class="page-item <?php if($PageCourante==$i) {echo "active"; }?>"><a class="page-link " href="listerProduit.php?pagecourante=<?php echo $i?>&debut=<?php echo $nbre*($i-1); ?>"><?php echo $i; ?></a></li>
                    <?php }?>

                    <?php
                    if($PageCourante !=$nbrePages){
                        ?><li class="page-item"><a class="page-link" href="listerProduit.php?pagecourante=<?php echo $PageCourante+1;?>&debut=<?php echo $debut+$nbre; ?>">Suivant</a></li><?php
                    }
                    ?>


                </ul>
            </nav>


            <button type="button" class="btn btn-success">
                Total <span class="badge badge-light"><?php echo count($reponsePage);?></span>

            </button>

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