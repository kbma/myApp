<?php
//var_dump($_POST);
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;

$CLIENT_ID =htmlspecialchars($_POST['CLIENT_ID']);
$DATE=date('Y-m-d');

$sql="INSERT INTO `commandes`(`CLIENT_ID`, `DATE`) VALUES ('$CLIENT_ID','$DATE')";

    $action =$c->query($sql);
    $last_id = $c->lastInsertId();

for($i=0; $i< count($_POST['PRODUIT_ID']); $i++){
    $produit_id= $_POST['PRODUIT_ID'][$i];
    $qte= $_POST['QTE'][$i];

    $sql="INSERT INTO `ligne_commandes`(`COMMANDE_ID`, `PRODUIT_ID`, `QTE`) VALUES ($last_id,$produit_id,$qte)";
    $c->query($sql);

}

    if($action){
        header('location:../AjouterCommande.php?type=success&message=Commande est ajouté avec succès');
    }else{
        header('location:../AjouterCommande.php?type=erreur&message=Une erreur est survenue lors d\'ajout');
    }





