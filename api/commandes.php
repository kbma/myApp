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
      getCommandes($id);
    }
    else
    {
      // Récupérer tous les produits
      getCommandes();
    }
    break;

  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

function getCommandes($id=0)
  {

    $sql="select * from commandes";
    if($id != 0)
    {
      $sql .= " WHERE id=".$id." LIMIT 1";
    }
      $crud = new crud();
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





  

?>