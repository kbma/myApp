<?php
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;


$sql = "DELETE from clients  WHERE ID=?";
$stmt= $c->prepare($sql);
$stmt->execute([$_POST['ID']]);
if($_POST['PHOTO_OLD']!=""){
    unlink("../".$_POST['PHOTO_OLD']);
}

if($stmt->rowCount() >0){
    header('location:../ListerClient.php?type=success&message=Le Client est supprimé!');
}else {
    header('location:../ListerClient.php?type=erreur&Rien n\'est supprimé');
}

