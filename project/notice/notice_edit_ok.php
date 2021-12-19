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

$notice_title = $_POST['notice_title'];
$notice_name = $_POST['notice_name'];
$notice_memo = $_POST['notice_memo'];
//$notice_id = $_POST['notice_id'];

if(isset($_POST['notice_top'])){
    $notice_top = "1";
}else {
    $notice_top = "0";
}

/*
$sql = "insert into gallery(gallery_title,gallery_name,gallery_email,gallery_content,
gallery_pass,gallery_id,gallery_wdate,gallery_hit,gallery_like) 
values ('".$gallery_title."','".$gallery_name."','".$gallery_email."',
'".$gallery_content."','".$gallery_pass."','".$gallery_id."',
'".$gallery_wdate."','".$gallery_hit."','".$gallery_like."')";
*/
$sql = "update notice set notice_title='".$notice_title."',notice_memo='".$notice_memo."',notice_top='".$notice_top."' where notice_idx=".$_POST['notice_idx']."";

$result = mysqli_query($con, $sql);
?>

<script>
    
    alert("공지사항 등록이 완료되었습니다.");
    location.href="notice_list.php?page=<?php echo $_POST['page']?>";
    
</script>
<?php
}
?>


