<?php
session_start();

include "../config/dbconnect.php";

$admin_id = $_POST['admin_id'];
$admin_pass = $_POST['admin_pass'];

if(($admin_id == "admin") && ($admin_pass == "1234")){
    $_SESSION['admin_id'] = "admin";
    $_SESSION['admin_pass'] = "관리자";
    echo "<script>alert('관리자로 로그인하였습니다.');location.href='/';</script>";
} else {
    echo "<script>alert('아이디 혹은 패스워드를 다시 입력해주세요.').history.back();</script>";
}


?>
