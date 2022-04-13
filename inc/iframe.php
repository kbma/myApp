<?php
include 'DB.php';
$mysql= new DB();
$c= $mysql->cnx;
$sql="SELECT pro.LIBELLE as 'label', COUNT(COMMANDE_ID) as 'y' FROM `ligne_commandes` as lig , `produits` as pro where lig.PRODUIT_ID=pro.ID GROUP by pro.LIBELLE";
$stmt=$c->query($sql);
$rs= $stmt->fetchAll(PDO::FETCH_ASSOC);

/*************/
$sql2="SELECT  COUNT(com.ID) as 'y',  clt.NOM as 'label' FROM `commandes` as com , `clients` as clt where com.CLIENT_ID=clt.ID GROUP by clt.NOM";
$stmt2=$c->query($sql2);
$rs2= $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>


        <script>
            window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light1", // "light1", "light2", "dark1", "dark2"
                    title:{
                        text: "Nombre des produit par commande",
                        fontSize:16
                    },
                    axisY:{
                        includeZero: true
                    },
                    data: [{
                        type: "column", //change type to bar, line, area, pie, etc
                        //indexLabel: "{y}", //Shows y value on all Data Points
                        indexLabelFontColor: "#5A5757",
                        indexLabelPlacement: "outside",
                        dataPoints: <?php echo json_encode($rs, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart.render();

            }
        </script>



        <div id="chartContainer"  ></div>


    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>





