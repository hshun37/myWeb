<?php
include "../config/db.php";


$b_title = $_POST["title"];
$b_secret = $_POST["secret"];
$b_name = $_POST["name"];
$b_email = $_POST["email"];
$b_content = $_POST["content"];
$b_password = $_POST["password"];
$b_date = date("Y-m-d H:i:s");
$b_ip=$_SERVER['REMOTE_HOST']; // $_SERVER['REMOTE_ADDR']

$b_userid=$_POST["userid"];

if($b_secret == ""){
	$b_secret=0;
}

//1. form문에서 넘어온 value 값을 변수로 지정한다.
//2. 데이터베이스를 연결한다.
//3. insert문을 이용하여 값을 저장한다.
//4. 데이터 입력 후 해당 위치로 이동한다.

$sql=mq("insert into board (b_title,b_name,b_email,b_secret,b_content,b_password,b_wdate,b_ip,b_userid)
	values ('".$b_title."','".$b_name."','".$b_email."',".$b_secret.",'".$b_content."','".$b_password."','".$b_date."','".$b_ip."','".$b_userid."')");
?>
<script>
alert("게시판 글이 등록되었습니다.");
location.href="write.php";
</script>