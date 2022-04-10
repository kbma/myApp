<?php
class crud{
    Public $servername='localhost';
    Public $username='root';
    Public $password='';
    Public $dbname='myapp';
    public $dbh= null;

    public function __construct(){
        
        try {
            $this->dbh = new PDO('mysql:host='.$this->servername.';dbname='.$this->dbname, $this->username, $this->password);
                    
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }       
             
    }

    public function ajouterProduit($nom,$pu,$qte){
        $sql="INSERT INTO `produits`(`NOM`, `PU`, `QTE`) VALUES ('".$nom."','".$pu."','".$qte."')";
        $res =$this->dbh->exec($sql);
    }

    public function redirection($url,$msg){
        echo '<script language="Javascript">
        <!--
        document.location.replace("'.$url.'?msg='.$msg.'");
        // -->
        </script>';
    }

    public function Produits($debut, $nbre){
        $sql="select * from produits  order by ID desc limit ".$debut.",".$nbre;
        $res =$this->dbh->prepare($sql);
        $res->execute();        
        $result = $res->fetchAll();
        return $result;
    }

    public function Nbre_Produits(){
        $sql="select * from produits";
        $res =$this->dbh->prepare($sql);
        $res->execute();        
        $result = $res->fetchAll();
        return $result;
    }

    public function Produit($ID){
        $sql="select * from produits where ID=".$ID;
        $res =$this->dbh->query($sql);               
        $result = $res->fetch();
        return $result;
    }
    public function modifierProduit($ID,$NOM,$PU,$QTE){
      $sql="UPDATE `produits` SET `PU` = ".$PU.", NOM='".$NOM."' , QTE=".$QTE."  WHERE `produits`.`ID` =".$ID;
        $res =$this->dbh->prepare($sql);               
        $res->execute();         
    }


    public function supprimerProduit($ID){
        $sql="delete from produits where ID=".$ID;
        $res =$this->dbh->query($sql);               
    
    }

    public function chercherProduit($key,$debut, $nbre){
        $sql="SELECT * FROM `produits` WHERE NOM LIKE '%".$key."%' limit ".$debut.",".$nbre;
        $res =$this->dbh->prepare($sql);
        $res->execute();        
        $result = $res->fetchAll();
        return $result;
    }

 //*****************  Crud Clients   ******************************

 public function ajouterClient($nom,$prenom,$tel){
    $sql="INSERT INTO `clients`(`NOM`, `PRENOM`, `TEL`) VALUES ('".$nom."','".$prenom."','".$tel."')";
    $res =$this->dbh->exec($sql);
}

public function Clients($debut, $nbre){
    $sql="select * from clients  order by ID desc limit ".$debut.",".$nbre;
    $res =$this->dbh->prepare($sql);
    $res->execute();        
    $result = $res->fetchAll();
    return $result;
}

public function Nbre_Clients(){
    $sql="select * from clients";
    $res =$this->dbh->prepare($sql);
    $res->execute();        
    $result = $res->fetchAll();
    return $result;
}

public function modifierClient($ID,$NOM,$PRENOM,$TEL){
    $sql="UPDATE `clients` SET `TEL` = ".$TEL.", NOM='".$NOM."' , PRENOM='".$PRENOM."'  WHERE `clients`.`ID` =".$ID;
      $res =$this->dbh->prepare($sql);               
      $res->execute();         
  }

  public function Client($ID){
    $sql="select * from clients where ID=".$ID;
    $res =$this->dbh->query($sql);               
    $result = $res->fetch();
    return $result;
}

  public function supprimerClient($ID){
      $sql="delete from clients where ID=".$ID;
      $res =$this->dbh->query($sql);               
  
  }

  public function chercherClient($key,$debut, $nbre){
      $sql="SELECT * FROM `clients` WHERE NOM LIKE '%".$key."%' limit ".$debut.",".$nbre;
      $res =$this->dbh->prepare($sql);
      $res->execute();        
      $result = $res->fetchAll();
      return $result;
  }

/**les commandes */

public function Commandes($debut, $nbre){
    $sql="select * from commandes  order by ID desc limit ".$debut.",".$nbre;
    $res =$this->dbh->prepare($sql);
    $res->execute();        
    $result = $res->fetchAll();
    return $result;
}


public function Nbre_Commandes(){
    $sql="select * from commandes";
    $res =$this->dbh->prepare($sql);
    $res->execute();        
    $result = $res->fetchAll();
    return $result;
}

public function ajouterCommande($CLIENT_ID,$PRODUIT_ID,$QTE){
    $DATE= date('Y-m-d');
    $sql="INSERT INTO `commandes`(`CLIENT_ID`, `DATE`) VALUES ('".$CLIENT_ID."','".$DATE."')";
    $res =$this->dbh->exec($sql);
    $last_id = $this->dbh->lastInsertId();
    for ($i =0; $i< count($PRODUIT_ID); $i++)
    {
        $sql1="INSERT INTO `liste`(`COMMANDE_ID`, `PRODUIT_ID`,`QTE`) VALUES ('".$last_id."','".$PRODUIT_ID[$i]."', '".$QTE[$i]."')";
        $res =$this->dbh->exec($sql1);
    }
}

public function ClientCommande($ID){
    $sql="select * from clients where ID=".$ID;
    $res =$this->dbh->query($sql);               
    $result = $res->fetch();
    return $result;
}

public function TotalCommande($ID){
    $sql="select * from liste where COMMANDE_ID=".$ID;
    $res =$this->dbh->prepare($sql);               
    $res->execute();        
    $result = $res->fetchAll();
    $total=0;
    foreach ($result as $row)
    {
        
         $p= $this->Produit($row['PRODUIT_ID'])['PU']; 
        
        $q= $row['QTE'];
       $total =$total + ($p*$q);
    }
    
    return $total;
}

}