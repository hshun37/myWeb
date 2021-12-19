<?php
include "../config/db.php";

$b_title=$_POST["title"];
$b_secrit=$_POST["secrit"];
$b_name=$_POST["name"];
$b_email=$_POST["email"];
$b_content=$_POST["content"];
$b_pass=$_POST["pass"];
$b_date=date("Y-m-d H:i:s");
$b_ip=$_SERVER['REMOTE_ADDR']; //$_SERVER['REMOTE_ADDR']




 	




$b_userid=$_POST["userid"];

if($b_secrit == ""){
$b_secrit=0;
}

$sql=mq("insert into board (b_title,b_name,b_email,b_secrit,b_content,b_pass,b_wdate,b_ip,b_userid) values ('".$b_title."','".$b_name."','".$b_email."',".$b_secrit.",'".$b_content."','".$b_pass."','".$b_date."','".$b_ip."','".$b_userid."')");
?>
<script>
alert("게시판 글이 등록되었습니다.");
location.href="list.php";
</script>