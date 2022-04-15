<?php
include 'CRUDClient.php';

$CRUD = new CRUDClient();

$ID= $_POST['ID'];
$PHOTO_OLD=$_POST['PHOTO_OLD'];
$action= $CRUD->deleteClient($ID,$PHOTO_OLD);
if($action){
    header('location:ListerClient.php?type=success&message=Le Client est supprimé!');
}else {
    header('location:ListerClient.php?type=erreur&Rien n\'est supprimé');
}

