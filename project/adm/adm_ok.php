<meta charset="UTF-8">
<?php
session_start();

include "../config/dbconnect.php"; //db 연결


$admin_id = $_POST['admin_id']; //form문에서 포스트값으로 넘어온 admin_id을(value값을) db에 있는(admin 테이블) 변수에 저장
$admin_pass = $_POST['admin_pass']; //form문에서 포스트값으로 넘어온 admin_pass를(value값을) db에 있는(admin 테이블) 변수에 저장

$sql = "select * from admin where admin_id'".$admin_id."'";
$result = mysqli_query($con,$sql); //sql 실행문
$row = mysqli_fetch_array($result);

$admin_pw = $row['admin_pass']; //admin_pass에 있는 값을 admin_pw라는 이름으로 저장

if($admin_pass == $admin_pw){ //form문에서 넘어온 비밀번호와 테이블에 있는 비밀번호가 같다면
    $_SESSION['admin_id'] = $row['admin_id'];
    $_SESSION['admin_name'] = $row['admin_name'];
    $_SESSION['admin_level'] = $row['admin_level'];

    //setcookie('admin_id',$row['admin_id'],time()+(86400*30),'/');

    echo "<script>alert('관리자로 접속하였습니다.');location.href='index.php';</script>";

} else {
    echo "<script>alert('아이디 혹은 비밀번호를 다시 확인해주세요.');history.back();</script>";
}

mysqli_close($con); //db 종료


?>


