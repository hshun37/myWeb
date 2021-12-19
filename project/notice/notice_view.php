<?php
session_start();

include "../config/dbconnect.php";

$sql = "select * from notice where notice_idx=".$_GET['notice_idx']."";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_array($result);

$notice_hit = $rows['notice_hit'] + 1;
$sql1="update notice set hit = '".$notice_hit."' notice_idx=".$_GET['notice_idx']."";
$result = mysqli_query($con, $sql1);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <title>Bootstrap 4 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  </style>
  
</head>
<body>

<!--헤더 시작-->
<?php
  include "../inc/header.php";
?>
<!--헤더 끝-->

<!--네비 시작-->
<?php
  include "../inc/navi.php"
?>
<!--네비 끝-->

<div class="container" style="margin-top:100px;margin-bottom:100px;">
    <div class="card">
        <h5 class="card-header">Notice</h5>
        <div class="card-body">
            <h5 class="card-title"><?php echo $rows['notice_title'];?></h5>
            <p class="card-text"><?php echo nl2br($rows['notice_memo']);?></p>
            <div class="card-footer">
            <small class="text-muted"><?php echo $rows['notice_wdate'];?></small>
            </div>
        </div>
    </div>
</div>

<?php
if(!isset($_SESSION['admin_id'])){
  ?>
  <div style="text-align:center;margin-top:20px;">
  <a class="btn btn-dark" href="notice_list.php?page=<?php echo $_GET['page']?>" role="button">목록</a>
  </div>
<?php
} else{
?>

<div style="text-align:center;margin-top:20px;">
<a class="btn btn-dark" href="notice_edit.php?notice_idx=<?php echo $rows['notice_idx'];?>&page=<?php echo $_GET['page']?>" role="button">수정</a>&nbsp;&nbsp;
<a class="btn btn-dark" href="notice_del.php?notice_idx=<?php echo $rows['notice_idx'];?>&page=<?php echo $_GET['page']?>" role="button">삭제</a>&nbsp;&nbsp;
<a class="btn btn-dark" href="notice_list.php?page=<?php echo $_GET['page']?>" role="button">목록</a>
</div>
<?php
}
?>

<!--푸터 시작-->
<?php
  include "../inc/footer.php"
?>
<!--푸터 끝-->

</body>
</html>
