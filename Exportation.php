<?php
include 'inc/DB.php';
$mysql= new DB();
$c= $mysql->cnx;

$sql = "SELECT * FROM `clients` order by ID";

$stmt=$c->query($sql);
$rs= $stmt->fetchAll(PDO::FETCH_ASSOC);



$records = array();
foreach ($rs as $rows ) {
    $records[] = $rows;
}

if(isset($_POST["export_data"])) {
    $filename = "Clients_".date('Ymd') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $show_coloumn = false;
    if(!empty($records)) {
        foreach($records as $record) {
            if(!$show_coloumn) {
                // display field/column names in first row
                echo implode("\t", array_keys($record)) . "\n";
                $show_coloumn = true;
            }
            echo implode("\t", array_values($record)) . "\n";
        }
    }
    exit;
}
?>
<?php include 'templates/haut.php';?>

    <div class="card">
        <h5 class="card-header">Exportation  : Clients en Excel</h5>
        <div class="card-body">

                <div class="well-sm col-sm-12">
                    <div class="btn-group pull-right">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <button type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-danger">Export to excel</button>
                        </form>
                    </div>
                    <div class="m-4"></div>
                </div>
                <table id="" class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Prenom</th>
                        <th>TEL</th>

                    </tr>
                    <tbody>
                    <?php foreach($records as $p) { ?>
                        <tr>
                            <td><?php echo $p ['ID']; ?></td>
                            <td><?php echo $p ['NOM']; ?></td>
                            <td><?php echo $p ['PRENOM']; ?></td>
                            <td><?php echo $p ['TEL']; ?></td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

        </div>

    </div>






<?php include 'templates/bas.php'; ?>