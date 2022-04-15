<?php include 'templates/haut.php';?>
<?php
include 'CRUDClient.php';

$CRUD = new CRUDClient();
$nbreClientParPage=5;
$nbrePages= $CRUD->nbrePages($nbreClientParPage);
$debut= $_GET['debut']??$_GET['debut']??0;
$nbre= $_GET['nbre']??$_GET['nbre']??$nbreClientParPage;
$PageCourante= $_GET['pagecourante']??$_GET['pagecourante']??1;

$sql = "SELECT * FROM `clients` order by ID DESC limit ".$debut.",".$nbreClientParPage;
$reponse = $CRUD->cnx->query($sql);


?>
    <div class="card">
        <h5 class="card-header">La liste des clients:  Total = <?php echo count($CRUD->getClients()); ?></h5>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Tél</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reponse as $client) { ?>
                <tr>
                    <th scope="row"><?php echo $client['ID']; ?></th>
                    <td><img src="<?php echo $client['PHOTO']; ?>" width="50px" /></td>
                    <td><?php echo $client['NOM']; ?></td>
                    <td><?php echo $client['PRENOM']; ?></td>
                    <td><?php echo $client['TEL']; ?></td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $client['ID']; ?>">
                            Modifier
                        </button>


                        <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo $client['ID']; ?>">
                            Supprimer
                        </button>

                        <!-- Modal Edit-->
                        <form action="UpdateClientAction.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $client['ID']; ?>" name="ID"/>
                            <input type="hidden" value="<?php echo $client['PHOTO']; ?>" name="PHOTO_OLD"/>
                            <div class="modal fade" id="exampleModal<?php echo $client['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modification du client : <?php echo $client['NOM']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="form-label">Nom</label>
                                                    <input type="text" class="form-control" name="NOM" value="<?php echo $client['NOM']; ?>">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Prénom</label>
                                                    <input type="text" class="form-control" name="PRENOM" value="<?php echo $client['PRENOM']; ?>">
                                                </div>
                                                <div class="col-4">
                                                    <label class="form-label">Tél</label>
                                                    <input type="text" class="form-control" name="TEL" value="<?php echo $client['TEL']; ?>">
                                                </div>
                                            </div>
                                            <div class="m-3"></div>
                                            <div class="row">
                                                <div class="col-9">
                                                    <input type="file" class="form-control" name="PHOTO">
                                                </div>
                                                <div class="col-3">
                                                    <img src="<?php echo $client['PHOTO']; ?>" width="50px"/>
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
                        <form action="DeleteClientAction.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $client['ID']; ?>" name="ID"/>
                            <input type="hidden" value="<?php echo $client['PHOTO']; ?>" name="PHOTO_OLD"/>
                            <div class="modal fade" id="exampleModalDelete<?php echo $client['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalDelete">Supprimer le client : <?php echo $client['NOM']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-3">
                                                    <img src="<?php echo $client['PHOTO']; ?>" width="50px"/>
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
                <?php } ?>

                </tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if($PageCourante != 1){
                        ?><li class="page-item"><a class="page-link" href="listerClient.php?pagecourante=<?php echo $PageCourante-1;?>&debut=<?php echo $debut-$nbre; ?>">Précédent</a></li><?php
                    }
                    ?>
                    <?php for($i=1; $i<=$nbrePages; $i++){?>
                        <li class="page-item <?php if($PageCourante==$i) {echo "active"; }?>"><a class="page-link " href="listerClient.php?pagecourante=<?php echo $i?>&debut=<?php echo $nbre*($i-1); ?>"><?php echo $i; ?></a></li>
                    <?php }?>

                    <?php
                    if($PageCourante !=$nbrePages){
                        ?><li class="page-item"><a class="page-link" href="listerClient.php?pagecourante=<?php echo $PageCourante+1;?>&debut=<?php echo $debut+$nbre; ?>">Suivant</a></li><?php
                    }
                    ?>


                </ul>
            </nav>



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