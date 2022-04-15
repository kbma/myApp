<?php
include "CRUDClient.php";
$CRUD = new CRUDClient();

$NOM =htmlspecialchars($_POST['NOM']);
$PRENOM =htmlspecialchars($_POST['PRENOM']);
$TEL =htmlspecialchars($_POST['TEL']);
$PHOTO=$_FILES['PHOTO'];


$action= $CRUD->addClient($NOM ,$PRENOM,$TEL,$PHOTO);
//var_dump($action->rowCount()); die();

if($action->rowCount() >0){
    header('location:AjouterClient.php?type=success&message=Client est ajouté avec succès');
}else{
    header('location:AjouterClient.php?type=erreur&message=Une erreur est survenue lors d\'ajout');
}

