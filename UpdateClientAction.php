<?php
include 'CRUDClient.php';

$CRUD = new CRUDClient();

$ID= $_POST['ID'];
$NOM =htmlspecialchars($_POST['NOM']);
$PRENOM =htmlspecialchars($_POST['PRENOM']);
$TEL =htmlspecialchars($_POST['TEL']);
$PHOTO=$_FILES['PHOTO'];
$PHOTO_OLD=$_POST['PHOTO_OLD'];

$stmt= $CRUD->updateClient($NOM,$PRENOM,$TEL,$PHOTO,$PHOTO_OLD,$ID);

if($stmt->rowCount() >0){
    header('location:ListerClient.php?type=success&message=Le Client est modifié!');
}else {
    header('location:ListerClient.php?type=erreur&message=Pas de modification');
}

