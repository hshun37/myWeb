<?php
if (isset($_POST['eventID'])) {
    require_once 'dbController.php';
    $datas = $_POST['eventID'];
    $dbController = new dbController();
    $test = "DELETE FROM event WHERE _id={$datas}";
    $result = $dbController->sql_exec("DELETE FROM event WHERE _id={$datas}");

    echo $result;
}
