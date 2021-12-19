<?php
    include "../db/dbCon.php";

    $sql = "create table member (
        memberID int unsigned not null auto_increment,
        password varchar(40) not null,
        email varchar(40) not null,
        nickname varchar(10) not null,
        birthday varchar(10) not null,
        regTime int(11) not null,
        primary key (memberID)
        )";

        $res = $dbConnect -> query($sql);

        if($res) {
            echo "테이블 생성 완료";
        } else {
            echo "테이블 생성 실패";
        }
?>