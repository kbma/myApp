<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapp";

$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
//$sql = "CREATE TABLE produits( ID INT(6) UNSIGNED AUTO_INCREMENT  PRIMARY KEY,LIBELLE VARCHAR(30) NOT NULL,  PRIX INTEGER (30) NOT NULL)";
//$conn->exec($sql);

//$sql = "INSERT INTO produits (LIBELLE,  PRIX) VALUES ('Prod1', 340) ";
//$conn->exec($sql);
$sql = "SELECT * FROM produits";
$reponse = $conn->query($sql);

while ($donnees = $reponse->fetch())
{
echo $donnees['ID']. " ".$donnees['LIBELLE']; echo "<br>";
}
$reponse->closeCursor();

