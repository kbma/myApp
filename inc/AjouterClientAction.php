<?php
//var_dump($_POST);
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;

$NOM =htmlspecialchars($_POST['NOM']);
$PRENOM =htmlspecialchars($_POST['PRENOM']);
$TEL =htmlspecialchars($_POST['TEL']);
$PHOTO_name="images/inconnu.jpg";

$sql = "SELECT * FROM `clients` WHERE NOM='".$NOM."' and PRENOM ='".$PRENOM."' and TEL='".$TEL."'";

$reponse = $c->query($sql);
$donnees = $reponse->fetch();
if($donnees){
    header('location:../AjouterClient.php?type=erreur&message=Client est existe!');
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

    echo $sql="INSERT INTO `clients`(`NOM`, `PRENOM`, `TEL`, `PHOTO`) VALUES ('$NOM','$PRENOM','$TEL','$PHOTO_name')";
    //die();
    $action =$c->query($sql);
    if($action){
        header('location:../AjouterClient.php?type=success&message=Client est ajouté avec succès');
    }else{
        header('location:../AjouterClient.php?type=erreur&message=Une erreur est survenue lors d\'ajout');
    }

}



