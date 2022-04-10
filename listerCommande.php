<?php include 'templates/haut.php';?>
<?php
include 'inc/DB.php';
$mysql= new DB();
$c= $mysql->cnx;
$debut= $_GET['debut']??$_GET['debut']??0;
$nbre= $_GET['nbre']??$_GET['nbre']??5;
$PageCourante= $_GET['pagecourante']??$_GET['pagecourante']??1;

$sql = "SELECT * FROM `commandes` order by ID DESC limit ".$debut.",".$nbre;
$reponse = $c->query($sql);

$sqlPage = "SELECT * FROM `commandes`";
$reponsePage = $c->query($sqlPage)->fetchAll();
$nbrePages=ceil(count($reponsePage)/$nbre,);

function getClient($id,$c){
    $sql = "SELECT * FROM `clients` where ID=".$id;
    $infos = $c->query($sql)->fetch();
    return $infos;
}

?>
    <div class="card">
        <h5 class="card-header">La liste des commandes:  </h5>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Client</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reponse as $commande) { ?>
                <tr>
                    <th scope="row"><?php echo $commande['ID']; ?></th>
                    <td><?php echo getClient($commande['CLIENT_ID'],$c)['NOM']." ".getClient($commande['CLIENT_ID'],$c)['PRENOM']; ?></td>
                    <td><?php echo $commande['DATE']; ?></td>

                    <td>
                        <!-- Button trigger modal -->
                        <a href="ImprimerCommandePDF.php?ID=<?php echo $commande['ID']; ?>" class="btn btn-primary ">
                            Imprimer
                        </a>


                    </td>
                </tr>
                <?php }?>

                </tbody>
            </table>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if($PageCourante != 1){
                        ?><li class="page-item"><a class="page-link" href="listercommande.php?pagecourante=<?php echo $PageCourante-1;?>&debut=<?php echo $debut-$nbre; ?>">Précédent</a></li><?php
                    }
                    ?>
                    <?php for($i=1; $i<=$nbrePages; $i++){?>
                        <li class="page-item <?php if($PageCourante==$i) {echo "active"; }?>"><a class="page-link " href="listercommande.php?pagecourante=<?php echo $i?>&debut=<?php echo $nbre*($i-1); ?>"><?php echo $i; ?></a></li>
                    <?php }?>

                    <?php
                    if($PageCourante !=$nbrePages){
                        ?><li class="page-item"><a class="page-link" href="listercommande.php?pagecourante=<?php echo $PageCourante+1;?>&debut=<?php echo $debut+$nbre; ?>">Suivant</a></li><?php
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