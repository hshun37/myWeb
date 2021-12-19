<?php
include "../config/dbconnect.php"; //dbconnect.php를 불러오기

//공지사항 테이블
$sql1 = "CREATE TABLE notice(
    notice_idx int(11) NOT NULL auto_increment,
    notice_title varchar(100) NOT NULL,
    notice_pass varchar(100) NOT NULL,
    notice_name varchar(100) NOT NULL,
    notice_memo text,
    notice_wdate varchar(100),
    notice_hit int,
    PRIMARY KEY(notice_idx)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$result = mysqli_query($con,$sql1);

if ($result) {
    echo "notice 테이블이 생성되었습니다.";
} else {
    echo "notice 테이블 생성에 실패하였습니다.".mysqli_error($con);
}

mysqli_close($con)


?>
<!--
<script>
    alert("DB가 생성되었습니다.");
    history.back();
</script>
-->