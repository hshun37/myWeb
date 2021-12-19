<meta charset="utf-8">
<?php
session_start();
if(!isset($_SESSION['admin_id'])){
?>
<script>
alert('접근이 불가능합니다.');
 history.back();
</script>
<?php
} else {

include "../config/dbconnect.php";
$sql = "delete from notice where notice_idx='".$_GET['notice_idx']."'";
$result = mysqli_query($con, $sql);
?>

<script>
    
    alert("공지사항이 삭제되었습니다");
    location.href="notice_list.php?page=<?php echo $_GET['page']?>";
    
</script>
<?php
}
?>


