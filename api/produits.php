<?php
include 'crud.php';
$request_method = $_SERVER["REQUEST_METHOD"];


switch($request_method)
{
  case 'GET':
    if(!empty($_GET["id"]))
    {
      // Récupérer un seul produit
      $id = intval($_GET["id"]);
      getProducts($id);
    }
    else
    {
      // Récupérer tous les produits
      getProducts();
    }
    break;

   case 'PUT':
   // Ajouter un produit
      AddProduct();
  break;
  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getProducts($id=0)
  {
    $crud = new crud();
    $sql="select * from produits";
    if($id != 0)
    {
      $sql .= " WHERE id=".$id." LIMIT 1";
    }

    $res =$crud->dbh->prepare($sql);
    $res->execute();        
    $result = $res->fetchAll();
    $response = array();
    foreach($result as $row)
    {
      $response[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
  }

/**méthode addProduct */

function AddProduct()
  {
    $crud = new crud();
   $NOM = $_GET["NOM"];
  $PU = $_GET["PU"];
   $QTE = $_GET["QTE"];
   
    $query="INSERT INTO produits(NOM, PU, QTE) VALUES('".$NOM."', '".$PU."', '".$QTE."')";
    $res =$crud->dbh->exec($query);
    header('Content-Type: application/json');
    echo json_encode($res);
  }



  

?>