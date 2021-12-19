<?php
if (isset($_POST['eventData'])) {
    require_once 'dbController.php';
    $datas = $_POST['eventData'];
    $dbController = new dbController();
    $test = "INSERT INTO event(title,description,start,end,backgroundColor,textColor,allDay)
    VALUES('{$datas['title']}','{$datas['description']}','{$datas['start']}','{$datas['end']}','{$datas['backgroundColor']}','{$datas['textColor']}',{$datas['allDay']})";
    // $test = "SELECT * FROM event WHERE start BETWEEN '" . $date . "-01' AND '" . $date . "-31'";
    $result = $dbController->sql_exec("INSERT INTO event(title,description,start,end,backgroundColor,textColor,allDay)
                                        VALUES('{$datas['title']}','{$datas['description']}','{$datas['start']}','{$datas['end']}','{$datas['backgroundColor']}','{$datas['textColor']}',{$datas['allDay']})");

    if ($result) {
        require_once 'email_send.php';

        $email = new emailController($datas['title'], $datas['description'], $datas['start'], $datas['end']);
        $email->startMailing();
    }
    echo $result;
}
