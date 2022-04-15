<?php
include 'fpdf/fpdf.php';
include 'CRUDClient.php';
include "CRUDProduit.php";
class CRUDCommande extends DB {

    public function Addcommande($CLIENT_ID) {
        $DATE = date('Y-m-d');
        $sql = "INSERT INTO `commandes`(`CLIENT_ID`, `DATE`) VALUES ('$CLIENT_ID','$DATE')";
        $action = $this->cnx->query($sql);
        $last_id = $this->cnx->lastInsertId();

        for ($i = 0; $i < count($_POST['PRODUIT_ID']); $i++) {
            $produit_id = $_POST['PRODUIT_ID'][$i];
            $qte = $_POST['QTE'][$i];
            $sql = "INSERT INTO `ligne_commandes`(`COMMANDE_ID`, `PRODUIT_ID`, `QTE`) VALUES ($last_id,$produit_id,$qte)";
            $this->cnx->query($sql);
        }
        return($action);
    }

    public function getIDClient($COMMANDE_ID) {

        $sql = "select * from commandes where ID =".$COMMANDE_ID;

        $reponse=$this->cnx->query($sql);
        $infos =$reponse->fetch();
        return $infos['CLIENT_ID'];
    }

    public function getInfosCommande($COMMANDE_ID) {

        $sql = "select * from commandes where ID =".$COMMANDE_ID;
        $reponse=$this->cnx->query($sql);
        $infos =$reponse->fetch();
        return $infos;
    }

    public function getLignesCommande($COMMANDE_ID) {

        $sql = "select * from ligne_commandes where COMMANDE_ID =".$COMMANDE_ID;
        $reponse=$this->cnx->query($sql);
        $infos =$reponse->fetchALL();
        return $infos;
    }

    public function ImprimerPDF($ID) {
        $CRUDClient = new CRUDClient();
        $idclient = $this->getIDClient($ID);
        $infos=$CRUDClient->getInfosClients($idclient);


        $CRUDProduit = new CRUDProduit();


        $infoscommande = $this->getInfosCommande($ID);
        $infoslignescommande = $this->getLignesCommande($ID);

        /* A4 width : 219mm */

        $pdf = new FPDF('P', 'mm', 'A4');

        $pdf->AddPage();
        /* output the result */

        /* set font to arial, bold, 14pt */
        $pdf->SetFont('Arial', 'B', 20);

        $pdf->Image('images/logo.jpg',1,5,40,0,'JPG');

        /* Cell(width , height , text , border , end line , [align] ) */

        $pdf->Cell(55, 10, '', 0, 0);
        $pdf->Cell(59, 5, 'Commande numero: '.$ID, 0, 0);
        $pdf->Cell(59, 10, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(71, 5, 'KETTERTHIL', 0, 0);
        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->Cell(59, 5, 'Details', 0, 1);

        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(130, 5, 'Bonne adresse', 0, 0);
        $pdf->Cell(25, 5, 'Customer ID: ', 0, 0);
        $pdf->Cell(34, 5, '0012', 0, 1);

        $pdf->Cell(130, 5, 'Delhi, 751001', 0, 0);
        $pdf->Cell(25, 5, 'Invoice Date:', 0, 0);
        $pdf->Cell(34, 5, $infoscommande['DATE'], 0, 1);

        $pdf->Cell(130, 5, '', 0, 0);
        $pdf->Cell(25, 5, 'Invoice No:', 0, 0);
        $pdf->Cell(34, 5, $infoscommande['ID'], 0, 1);

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(130, 5, $infos['NOM'].' '.$infos['PRENOM'], 0, 0);
        $pdf->Cell(59, 5, '', 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(189, 10, '', 0, 1);

        $pdf->Cell(50, 10, '', 0, 1);



        $pdf->SetFont('Arial', 'B', 10);
        /* Heading Of the table */
        $pdf->Cell(10, 6, 'Identifiant', 1, 0, 'C');
        $pdf->Cell(80, 6, 'Description', 1, 0, 'C');
        $pdf->Cell(23, 6, 'Qte', 1, 0, 'C');
        $pdf->Cell(30, 6, 'PU', 1, 0, 'C');
        $pdf->Cell(20, 6, 'TVA', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Total', 1, 1, 'C'); /* end of line */
        /* Heading Of the table end */
        $pdf->SetFont('Arial', '', 10);

        foreach( $infoslignescommande as $ligne)
        {

            $infosproduits=$CRUDProduit->getInfosProduit($ligne['PRODUIT_ID']);
            //var_dump($infosproduits['LIBELLE']);
            //die();

            $pdf->Cell(10, 6, $ligne['ID'], 1, 0);

            $pdf->Cell(80, 6, 'gfgdf', 1, 0);
            $pdf->Cell(23, 6, 765, 1, 0, 'R');
            $pdf->Cell(30, 6, 67, 1, 0, 'R');
            $pdf->Cell(20, 6, '100.00', 1, 0, 'R');
            $pdf->Cell(25, 6, 100, 1, 1, 'R');
        }




        $pdf->Cell(118, 6, '', 0, 0);
        $pdf->Cell(25, 6, 'Subtotal', 0, 0);
        $pdf->Cell(45, 6, '151000.00', 1, 1, 'R');

        $pdf->Output();
    }

}
