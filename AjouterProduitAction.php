<?php
//var_dump($_POST);
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;

$LIBELLE =htmlspecialchars($_POST['LIBELLE']);
$PRIX =htmlspecialchars($_POST['PRIX']);

$PHOTO_name="images/produit.jpg";

$sql = "SELECT * FROM `produits` WHERE LIBELLE='".$LIBELLE."' and PRIX ='".$PRIX."'";

$reponse = $c->query($sql);
$donnees = $reponse->fetch();
if($donnees){
    header('location:../AjouterProduits.php?type=erreur&message=Produit est existe!');
}else{
    if(isset($_FILES['PHOTO'])){
        if($_FILES['PHOTO']['name']!=""){
            var_dump($_FILES['PHOTO']);
            $PHOTO_name = $_FILES['PHOTO']['name'];
            $PHOTO_type = $_FILES['PHOTO']['type'];
            $PHOTO_taille =$_FILES['PHOTO']['size'];
            $PHOTO_temp= $_FILES['PHOTO']['tmp_name'];
            $PHOTO_erreur= $_FILES['PHOTO']['error'];
            if($PHOTO_erreur ==0){
                move_uploaded_file($PHOTO_temp, "../images/".time().'_'.$PHOTO_name);
                $PHOTO_name= "images/".time().'_'.$PHOTO_name;
            }

        }
    }

    echo $sql="INSERT INTO `produits`(`LIBELLE`, `PRIX`, `PHOTO`) VALUES ('$LIBELLE','$PRIX','$PHOTO_name')";
    //die();
    $action =$c->query($sql);
    if($action){
        header('location:../AjouterProduit.php?type=success&message=Produit est ajouté avec succès');
    }else{
        header('location:../AjouterProduit.php?type=erreur&message=Une erreur est survenue lors d\'ajout');
    }

}



