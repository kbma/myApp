<?php
include  'inc/DB.php';
class CRUDClient extends DB
{

    public function addClient($NOM,$PRENOM,$TEL,$PHOTO){
        $PHOTO_name="images/inconnu.jpg";
        //print_r($PHOTO); die();
        $sql = "SELECT * FROM `clients` WHERE NOM='".$NOM."' and PRENOM ='".$PRENOM."' and TEL='".$TEL."'";
        $reponse = $this->cnx->query($sql);
        $donnees = $reponse->fetch();
        if($donnees){
            header('location:AjouterClient.php?type=erreur&message=Client est existe!');
        }else{
            if(isset($PHOTO)){
                if($PHOTO['name']!=""){
                    $PHOTO_name = $PHOTO['name'];
                    $PHOTO_type = $PHOTO['type'];
                    $PHOTO_taille =$PHOTO['size'];
                    $PHOTO_temp= $PHOTO['tmp_name'];
                    $PHOTO_erreur= $PHOTO['error'];
                    if($PHOTO_erreur ==0){
                        move_uploaded_file($PHOTO_temp, "images/".time().'_'.$PHOTO_name);
                        $PHOTO_name= "images/".time().'_'.$PHOTO_name;
                    }
                }
            }
            $sql="INSERT INTO `clients`(`NOM`, `PRENOM`, `TEL`, `PHOTO`) VALUES ('$NOM','$PRENOM','$TEL','$PHOTO_name')";
            $action =$this->cnx->query($sql);
            return $action;
        }
    }

    public function getInfosClients($ID){
        $sql = "select *  from clients where ID =" . $ID;
        $reponse=$this->cnx->query($sql);
        $infos =$reponse->fetch();
        return $infos;
    }

    public function getClients(){
        $sql = "select *  from clients ";
        $reponse=$this->cnx->query($sql);
        $infos =$reponse->fetchAll();
        return $infos;
    }

    public function updateClient($NOM, $PRENOM, $TEL, $PHOTO,$PHOTO_OLD, $ID){
        $PHOTO_name="images/inconnu.jpg";
        if(isset($PHOTO)){
            if($PHOTO['name']!=""){
                //var_dump($_FILES['PHOTO']);
                $PHOTO_name = $PHOTO['name'];
                $PHOTO_temp= $PHOTO['tmp_name'];
                $PHOTO_erreur= $PHOTO['error'];
                if($PHOTO_erreur ==0){
                    move_uploaded_file($PHOTO_temp, "images/".time().'_'.$PHOTO_name);
                    $PHOTO_name= "images/".time().'_'.$PHOTO_name;
                    if($PHOTO_OLD!=='images/inconnu.jpg'){
                        unlink("".$PHOTO_OLD);
                    }
                }
            }
        }

        $sql = "UPDATE clients SET NOM=?, PRENOM=?, TEL=? , PHOTO=? WHERE ID=?";
        $stmt= $this->cnx->prepare($sql);
        $stmt->execute([$NOM, $PRENOM, $TEL, $PHOTO_name,$_POST['ID']]);
        return $stmt;
    }

    public function deleteClient($id,$PHOTO_OLD){

        $sql = "DELETE from clients  WHERE ID=?";
        $stmt= $this->cnx->prepare($sql);
        $action=$stmt->execute([$id]);
        if($PHOTO_OLD!=""){
            if($PHOTO_OLD!=='images/inconnu.jpg'){
                unlink("".$PHOTO_OLD);
            }
        }
        return $action;
    }

    public function nbrePages($nbre){

        $sqlPage = "SELECT * FROM `clients`";
        $reponsePage = $this->cnx->query($sqlPage)->fetchAll();
        $nbrePages=ceil(count($reponsePage)/$nbre,);
        return$nbrePages;
    }


}