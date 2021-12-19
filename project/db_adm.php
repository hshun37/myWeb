<?php
include "config/dbconnect.php"; //dbconnect.php를 불러오기

//관리자 테이블
$sql = "CREATE TABLE admin(
    admin_idx int(11) NOT NULL auto_increment,
    admin_id varchar(100) NOT NULL,
    admin_pass varchar(100) NOT NULL,
    admin_name varchar(100) NOT NULL,
    admin_level int,
    PRIMARY KEY(admin_idx)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$result = mysqli_query($con,$sql);

if ($result) {
    echo "관리자 테이블이 생성되었습니다.";
} else {
    echo "관리자 테이블 생성에 실패하였습니다.".mysqli_error($con);
}

//관리자 정보입력
$sql1 = "INSERT INTO admin(
    admin_id,admin_pass,admin_name,admin_level
    ) values ('admin','1234','관리자',1)
    ;
";

$result = mysqli_query($con,$sql1);

if ($result) {
    echo "관리자 정보 입력 완료";
} else {
    echo "관리자 정보 입력 실패".mysqli_error($con);
}

mysqli_close($con)


?>
<!--
<script>
    alert("DB가 생성되었습니다.");
    history.back();
</script>
-->