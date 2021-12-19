<?php
if (isset($_POST['date'])) {
    require_once 'dbController.php';
    $date = $_POST['date'];

    $dbController = new dbController();
    $test = "SELECT * FROM event WHERE start BETWEEN '{$date}-01' AND '{$date}-31' OR end BETWEEN '{$date}-01' AND '{$date}-31'";
    $datas = $dbController->sql_select("SELECT * FROM event WHERE start BETWEEN '{$date}-01' AND '{$date}-31' OR end BETWEEN '{$date}-01' AND '{$date}-31'");
    if (!empty($datas)) {
        echo json_encode($datas);
    }
}
