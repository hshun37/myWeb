<?php
include "../config/dbconnect.php"; //dbconnect.php를 불러오기

//갤러리 테이블
$sql = "CREATE TABLE gallery(
    gallery_idx int(11) NOT NULL auto_increment,
    gallery_title varchar(100) NOT NULL,
    gallery_name varchar(100) NOT NULL,
    gallery_email varchar(100) NOT NULL,
    gallery_content text,
    gallery_pass varchar(200),
    gallery_wdate varchar(100),
    gallery_hit int,
    gallery_like int,
    gallery_id varchar(100),
    file_name_0 varchar(100),
    file_name_1 varchar(100),
    file_name_2 varchar(100),
    file_copied_0 varchar(100),
    file_copied_1 varchar(100),
    file_copied_2 varchar(100),

    PRIMARY KEY(gallery_idx)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$result = mysqli_query($con,$sql);

if ($result) {
    echo "gallery 테이블이 생성되었습니다.";
} else {
    echo "gallery 테이블 생성에 실패하였습니다.".mysqli_error($con);
}

?>
<!--
<script>
    alert("DB가 생성되었습니다.");
    history.back();
</script>
-->