<?php
include "config/dbconnect.php"; //dbconnect.php를 불러오기

//회원가입 테이블
$sql = "CREATE TABLE member_join(
    join_idx int(11) NOT NULL auto_increment,
    join_id varchar(100) NOT NULL,
    join_pass varchar(100) NOT NULL,
    join_name varchar(100) NOT NULL,
    join_phone varchar(100),
    join_email varchar(200),
    join_level int,
    join_wdate varchar(100),
    PRIMARY KEY(join_idx)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$result = mysqli_query($con,$sql);

if ($result) {
    echo "member_join 테이블이 생성되었습니다.";
} else {
    echo "member_join 테이블 생성에 실패하였습니다.".mysqli_error($con);
}

//공지사항 테이블
$sql1 = "CREATE TABLE member_notice(
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
    echo "member_notice 테이블이 생성되었습니다.";
} else {
    echo "member_notice 테이블 생성에 실패하였습니다.".mysqli_error($con);
}

mysqli_close($con)


?>
<!--
<script>
    alert("DB가 생성되었습니다.");
    history.back();
</script>
-->