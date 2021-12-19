<?php
    $host = "localhost:3306";
    $user = "root";
    $pw = "root";
    $dbName = "google";
    $dbConnect = new mysqli($host, $user, $pw, $dbName);
    $dbConnect->set_charset("utf8");

    if(mysqli_connect_errno()) {
        echo "데이터베이스 {$dbName}에 접속 실패";
    }
?>