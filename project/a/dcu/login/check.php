<?php
include "../config/db.php";

$user_id = $_GET['user_id'];

$sql1="select *from member where user_id='".$user_id."'";
$result1 = mysqli_query($db, $sql1);
$row = mysqli_fetch_array($result1);

if ($row==0){
?>
	<div><?php echo $user_id; ?>는 사용가능한 아이디입니다.</div>
<?php
} else {
?>
	<div><?php echo $user_id; ?>는 중복된 아이디입니다.</div>
<?php
}
?>
<button value="닫기" onclick="window.close()">닫기</button>










