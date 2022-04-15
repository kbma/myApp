<?php include 'templates/haut.php';
include 'inc/DB.php';
$DB = new DB();
$debut =$_GET['debut']??$_GET['debut']??0;
$nbre =$_GET['nbre']??$_GET['nbre']??5;

$where="";

if(isset($_POST['MC'])){
    if(!empty($_POST['MC'])){
        $where=" where NOM like '%".$_POST['MC']."%' or PRENOM like '%".$_POST['MC']."%' or TEL like '%".$_POST['MC']."%'";
        $_SESSION['paginate']="&MC=".$_POST['MC'];
    }
}

if(isset($_GET['MC'])){
    if(!empty($_GET['MC'])){
        $where=" where NOM like '%".$_GET['MC']."%' or PRENOM like '%".$_GET['MC']."%' or TEL like '%".$_GET['MC']."%'";
        $_SESSION['paginate']="&MC=".$_GET['MC'];
    }
}
if(!isset($_SESSION['paginate'])){
    $_SESSION['paginate']="";
}

$sql= "select * from clients $where limit ".$debut.",".$nbre;
$clients= $DB->cnx->query($sql);

#Calculer le nbre des page
$sqlPage= "select * from clients $where";
$reponsePAge= $DB->cnx->query($sqlPage)->fetchAll();
$nbrePage =ceil(count($reponsePAge)/$nbre);

$PageCourante=$_GET['PageCourante']??$_GET['PageCourante']??1;

?>


    <div class="card">
        <div class="card-header"><h5>Chercher clients</h5></div>
        <div class="card-body">
            <!-------le formulaire de recherche---------->
            <form class="row g-3" action="chercherClient.php" method="post">
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
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Tél</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($clients as $client){?>
                    <tr>
                        <th scope="row"><?php echo $client['ID']; ?></th>
                        <td><img src="<?php if($client['PHOTO']==""){ echo "images/inconnu.jpg"; } else{ echo $client['PHOTO']; }; ?>"  width="50px"/></td>
                        <td><?php echo $client['NOM']; ?></td>
                        <td><?php echo $client['PRENOM']; ?></td>
                        <td><?php echo $client['TEL']; ?></td>
                        <td>
                            <!-----Modification ----->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModifierClient<?php echo $client['ID'];?>">Modifier</button>
                            <!-- Modal -->
                            <div class="modal fade" id="ModifierClient<?php echo $client['ID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form action="updateClientAction.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?php echo $client['ID']; ?>" name="ID"/>
                                            <input type="hidden" value="<?php echo $client['PHOTO']; ?>" name="PHOTO_OLD"/>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modifier le client: <?php echo $client['NOM'];?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label class="form-label">NOM</label>
                                                        <input type="text" name="NOM" class="form-control" value="<?php echo $client['NOM'];?>" required>
                                                    </div>

                                                    <div class="col-4">
                                                        <label class="form-label">PRENOM</label>
                                                        <input type="text" name="PRENOM" class="form-control" value="<?php echo $client['PRENOM'];?>"required>
                                                    </div>

                                                    <div class="col-4">
                                                        <label class="form-label">Tél</label>
                                                        <input type="tel" name="TEL" class="form-control" value="<?php echo $client['TEL'];?>" required>
                                                    </div>

                                                </div>

                                                <div class="m-2"></div>
                                                <div class="row">
                                                    <div class="col-9">
                                                        <input type="file" name="PHOTO" class="form-control">
                                                    </div>
                                                    <div class="col-3">
                                                        <img src="<?php echo $client['PHOTO'];?>" width="50px"/>
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#SupprimerClient<?php echo $client['ID'];?>">Supprimer</button>
                            <!-- Modal -->
                            <div class="modal fade" id="SupprimerClient<?php echo $client['ID'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form action="DeleteClientAction.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" value="<?php echo $client['ID']; ?>" name="ID"/>
                                            <input type="hidden" value="<?php echo $client['PHOTO']; ?>" name="PHOTO"/>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Supprimer le client: <?php echo $client['NOM'];?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <input type="submit" class="btn btn-danger" value="Supprimer le client"/>
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
                    ?>  <li class="page-item"><a class="page-link" href="chercherClient.php?PageCourante=<?php echo $PageCourante-1;?><?php echo $_SESSION['paginate']; ?>&debut=<?php echo $debut-$nbre;?>">Précédent</a></li><?php
                }
                ?>

                <?php for($i=1; $i<= $nbrePage; $i++){?>
                    <li class="page-item <?php if($PageCourante==$i){echo "active"; }?>"><a class="page-link" href="chercherClient.php?PageCourante=<?php echo $i;?><?php echo $_SESSION['paginate']; ?>&debut=<?php echo $nbre*($i-1);?>"><?php echo $i; ?></a></li>
                <?php }?>

                <?php
                if($PageCourante!=$nbrePage){
                    ?>
                    <li class="page-item"><a class="page-link" href="chercherClient.php?PageCourante=<?php echo $PageCourante+1;?><?php echo $_SESSION['paginate']; ?>&debut=<?php echo $debut+$nbre;?>">Suivant</a></li>
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