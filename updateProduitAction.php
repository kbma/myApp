<?php
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;

$LIBELLE =htmlspecialchars($_POST['LIBELLE']);
$PRIX =htmlspecialchars($_POST['PRIX']);

$PHOTO_name="images/produit.jpg";

if(isset($_FILES['PHOTO'])){
    if($_FILES['PHOTO']['name']!=""){
        //var_dump($_FILES['PHOTO']);
        $PHOTO_name = $_FILES['PHOTO']['name'];
        $PHOTO_type = $_FILES['PHOTO']['type'];
        $PHOTO_taille =$_FILES['PHOTO']['size'];
        $PHOTO_temp= $_FILES['PHOTO']['tmp_name'];
        $PHOTO_erreur= $_FILES['PHOTO']['error'];
        if($PHOTO_erreur ==0){
            move_uploaded_file($PHOTO_temp, "../images/".time().'_'.$PHOTO_name);
            $PHOTO_name= "images/".time().'_'.$PHOTO_name;
            unlink("../".$_POST['PHOTO_OLD']);
        }

    }else{
        $PHOTO_name=$_POST['PHOTO_OLD'];
    }
}

var_dump($PHOTO_name);
//die();
echo $sql = "UPDATE produits SET LIBELLE=?, PRIX=?, PHOTO=? WHERE ID=?";

$stmt= $c->prepare($sql);
$stmt->execute([$LIBELLE, $PRIX,  $PHOTO_name,$_POST['ID']]);


if($stmt->rowCount() >0){
    header('location:../ListerProduit.php?type=success&message=Le Client est modifié!');
}else {
    header('location:../ListerProduit.php?type=erreur&message=Pas de modification');
}

