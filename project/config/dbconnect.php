<?php
    $host = "localhost:3306";
    $user = "root";
    $pw = "root";
    $dbName = "web1";
    $con = new mysqli($host, $user, $pw, $dbName);
    $con->set_charset("utf8");

    if(mysqli_connect_errno()) {
        echo "데이터베이스 {$dbName}에 접속 실패";
    }
?>