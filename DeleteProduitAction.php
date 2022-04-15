<?php
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;


$sql = "DELETE from produits  WHERE ID=?";
$stmt= $c->prepare($sql);
$stmt->execute([$_POST['ID']]);
if($_POST['PHOTO_OLD']!=""){
    unlink("../".$_POST['PHOTO_OLD']);
}

if($stmt->rowCount() >0){
    header('location:../ListerProduit.php?type=success&message=Le Produit est supprimé!');
}else {
    header('location:../ListerProduit.php?type=erreur&Rien n\'est supprimé');
}

