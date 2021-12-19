<?php
include "../config/dbconnect.php"; //dbconnect.php를 불러오기

//갤러리 테이블
$sql = "CREATE TABLE board(
    board_idx int(11) NOT NULL auto_increment,
    board_title varchar(100) NOT NULL,
    board_name varchar(100) NOT NULL,
    board_content text,
    board_pass varchar(200),
    board_wdate varchar(100),
    file_name_0 varchar(200),
    file_copied_0 varchar(200),

    PRIMARY KEY(board_idx)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$result = mysqli_query($con,$sql);

if ($result) {
    echo "board 테이블이 생성되었습니다.";
} else {
    echo "board 테이블 생성에 실패하였습니다.".mysqli_error($con);
}
?>

