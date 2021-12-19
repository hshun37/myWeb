<?php
    include "../db/dbCon.php";
    $sql = "create table board (
        boardID int(10) unsigned not null auto_increment,
        memberID varchar(10) not null,
        title varchar(50) not null,
        content longtext not null,
        regTime int(10) unsigned not null,
        primary key (boardID)
        )";

        $res = $dbConnect -> query($sql);
        if($res) {
            echo "테이블 생성 완료";
        } else {
            echo "테이블 생성 실패";
        }
?>