<?php
if (isset($_POST['eventData'])) {
    require_once 'dbController.php';
    $datas = $_POST['eventData'];
    $dbController = new dbController();
    $test = "UPDATE event SET title='{$datas['title']}',description='{$datas['description']}',start='{$datas['start']}'
            ,end='{$datas['end']}',backgroundColor='{$datas['backgroundColor']}',textColor='{$datas['textColor']}',allDay={$datas['allDay']} WHERE _id={$datas['_id']}";

    $result = $dbController->sql_exec("UPDATE event SET title='{$datas['title']}',description='{$datas['description']}',start='{$datas['start']}'
                                     ,end='{$datas['end']}',backgroundColor='{$datas['backgroundColor']}',textColor='{$datas['textColor']}',allDay={$datas['allDay']} WHERE _id={$datas['_id']}");

    echo $result;
    // if (!empty($datas)) {
    //     echo json_encode($datas);
    // }
}
