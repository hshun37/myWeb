<?php
//session_start();
include "../config/dbconnect.php";

$user_id=$_POST["user_id"];
$user_pass=$_POST["user_pass"];

$query = "SELECT * FROM register WHERE user_id='$user_id' and user_pass='$user_pass'";
$result = mysqli_query($db, $query); //SQL문 실행

$row = mysqli_fetch_array($result); //실행된 결과값의 각 필드

if($user_id==$row['user_id'] && $user_pass==$row['user_pass']) {
	
	// $_SESSION['user_id']=$row['user_id'];
	// $_SESSION['user_name']=$row['user_name'];

	echo "<script>alert('로그인이 되었습니다.');</script>";

} else {

	echo "<script>alert('아이디 혹은 비밀번호를 확인하세요');</script>";

}

?>