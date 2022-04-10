<?php
/*call the FPDF library*/
require('fpdf184/fpdf.php');

include 'inc/DB.php';
$mysql= new DB();
$c= $mysql->cnx;

$sql = "SELECT * FROM `commandes` where ID=".$_GET['ID'];
$commande = $c->query($sql)->fetch();

$sqlClient = "SELECT * FROM `clients` where ID=".$commande['CLIENT_ID'];
$client = $c->query($sqlClient)->fetch();

$sqlLignes = "SELECT * FROM `ligne_commandes` where COMMANDE_ID=".$commande['ID'];
$lignes = $c->query($sqlLignes);

function getProdtuit($id, $c){
    $sqlProduit = "SELECT * FROM `produits` where ID=".$id;
    $infosProduit = $c->query($sqlProduit)->fetch();
    return $infosProduit;
}

$tva=0.19;
//echo getProdtuit(3,$c)['LIBELLE']; die();
/*A4 width : 219mm*/

$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();
/*output the result*/

/*set font to arial, bold, 14pt*/
$pdf->SetFont('Arial','B',20);

/*Cell(width , height , text , border , end line , [align] )*/
$pdf->Image('images/logo2.JPG',10,5,40,0,'JPG');
$pdf->Cell(71 ,10,'',0,0);
$pdf->Cell(59 ,5,'Commande',0,0);
$pdf->Cell(59 ,10,'',0,1);

$pdf->SetFont('Arial','B',15);
$pdf->Cell(71 ,5,'Laboratoire Ketterthill',0,0);
$pdf->Cell(59 ,5,'',0,0);
$pdf->Cell(59 ,5,'Details',0,1);

$pdf->SetFont('Arial','',10);

$pdf->Cell(130 ,5,'8, avenue du Swing',0,0);
$pdf->Cell(25 ,5,'Customer ID:',0,0);
$pdf->Cell(34 ,5,$commande['CLIENT_ID'],0,1);

$pdf->Cell(130 ,5,'L-4367 Belvaux',0,0);
$pdf->Cell(25 ,5,'Invoice Date:',0,0);
$pdf->Cell(34 ,5,$commande['DATE'],0,1);

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Invoice No:',0,0);
$pdf->Cell(34 ,5,$commande['ID'],0,1);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(130 ,4,'Pour :'.$client['NOM']." ".$client['PRENOM'],0,0);
$pdf->Cell(59 ,5,'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(189 ,10,'',0,1);



$pdf->Cell(50 ,10,'',0,1);

$pdf->SetFont('Arial','B',10);
/*Heading Of the table*/
$pdf->Cell(10 ,6,'#ID',1,0,'C');
$pdf->Cell(80 ,6,'Description',1,0,'C');
$pdf->Cell(23 ,6,'Qte',1,0,'C');
$pdf->Cell(30 ,6,'Prix unitaire',1,0,'C');
$pdf->Cell(20 ,6,'Sales Tax',1,0,'C');
$pdf->Cell(25 ,6,'Total',1,1,'C');/*end of line*/
/*Heading Of the table end*/
$pdf->SetFont('Arial','',10);
$total=0;
foreach ($lignes as $l) {
    $pdf->Cell(10 ,6,$l['ID'],1,0);
    $pdf->Cell(80 ,6,utf8_decode(getProdtuit($l['PRODUIT_ID'], $c)['LIBELLE']),1,0);
    $pdf->Cell(23 ,6,$l['QTE'],1,0,'R');
    $pdf->Cell(30 ,6,getProdtuit($l['PRODUIT_ID'], $c)['PRIX'],1,0,'R');
    $pdf->Cell(20 ,6,getProdtuit($l['PRODUIT_ID'], $c)['PRIX']*(1+$tva),1,0,'R');
    $pdf->Cell(25 ,6,getProdtuit($l['PRODUIT_ID'], $c)['PRIX']*(1+$tva)*$l['QTE'],1,1,'R');
    $total= $total+ getProdtuit($l['PRODUIT_ID'], $c)['PRIX']*(1+$tva)*$l['QTE'];
}


$pdf->Cell(118 ,6,'',0,0);
$pdf->Cell(25 ,6,'Total',0,0);
$pdf->Cell(45 ,6,$total,1,1,'R');


$pdf->Output('');

?>
