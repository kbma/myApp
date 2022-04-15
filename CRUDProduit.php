<?php
include_once 'inc/DB.php';
class CRUDProduit extends DB{


    public function getInfosProduit($ID) {
        $sql = "select * from produits where ID =".$ID;
        $reponse=$this->cnx->query($sql);
        $infos =$reponse->fetch();
        return $infos;
    }

    public function AddProduit(string $LIBELLE,int $PRIX, $PHOTO){
        $PHOTO_name="images/produit.jpg";

        $sql = "SELECT * FROM `produits` WHERE LIBELLE='".$LIBELLE."' and PRIX ='".$PRIX."'";

        $reponse = $this->cnx->query($sql);
        $donnees = $reponse->fetch();
        if($donnees){
            header('location:AjouterProduits.php?type=erreur&message=Produit est existe!');
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
                        move_uploaded_file($PHOTO_temp, "images/".time().'_'.$PHOTO_name);
                        $PHOTO_name= "images/".time().'_'.$PHOTO_name;
                    }
                }
            }

            $sql="INSERT INTO `produits`(`LIBELLE`, `PRIX`, `PHOTO`) VALUES ('$LIBELLE','$PRIX','$PHOTO_name')";

            $action =$this->cnx->query($sql);
            if($action){
                header('location:AjouterProduit.php?type=success&message=Produit est ajouté avec succès');
            }else{
                header('location:AjouterProduit.php?type=erreur&message=Une erreur est survenue lors d\'ajout');
            }

        }

    }


    public  function UpdateProduit(string $LIBELLE, int $PRIX,$ID, $PHOTO, string $PHOTO_OLD){

        $PHOTO_name="images/produit.jpg";

        if(isset($PHOTO)){
            if($PHOTO['name']!=""){
                //var_dump($_FILES['PHOTO']);
                $PHOTO_name = $PHOTO['name'];

                $PHOTO_temp= $PHOTO['tmp_name'];
                $PHOTO_erreur= $PHOTO['error'];
                if($PHOTO_erreur ==0){
                    move_uploaded_file($PHOTO_temp, "images/".time().'_'.$PHOTO_name);
                    $PHOTO_name= "images/".time().'_'.$PHOTO_name;
                    unlink("".$PHOTO_OLD);
                }

            }else{
                $PHOTO_name=$PHOTO_OLD;
            }
        }

        var_dump($PHOTO_name);
//die();
        echo $sql = "UPDATE produits SET LIBELLE=?, PRIX=?, PHOTO=? WHERE ID=?";

        $stmt= $this->cnx->prepare($sql);
        $stmt->execute([$LIBELLE, $PRIX,  $PHOTO_name,$ID]);


        if($stmt->rowCount() >0){
            header('location:ListerProduit.php?type=success&message=Le Client est modifié!');
        }else {
            header('location:ListerProduit.php?type=erreur&message=Pas de modification');
        }

    }

    public function DeleteProduit (int $id, $PHOTO_OLD){

        $sql = "DELETE from produits  WHERE ID=?";
        $stmt= $this->cnx->prepare($sql);
        $stmt->execute([$id]);
        if($PHOTO_OLD!=""){
            unlink("".$PHOTO_OLD);
        }

        if($stmt->rowCount() >0){
            header('location:ListerProduit.php?type=success&message=Le Produit est supprimé!');
        }else {
            header('location:ListerProduit.php?type=erreur&Rien n\'est supprimé');
        }


    }

}