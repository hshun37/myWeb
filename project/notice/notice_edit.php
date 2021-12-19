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

$sql = "select * from notice where notice_idx='".$_GET['notice_idx']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

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

<!--공지사항 글 등록-->
<div class="container" style="margin-top:100px;margin-bottom:100px;">
<h1>Notice</h1>
<form method="post" action="notice_edit_ok.php" enctype="multipart/form-data"> <!--enctype="multipart/from-data" : 사진과 text가 같이 들어가게 함-->
<input type="hidden" name="notice_idx" value="<?php echo $row['notice_idx']?>">
<input type="hidden" name="page" value="<?php echo $_GET['page']?>">
  <div class="form-group">
    <label for="notice_title">Title</label>
    <input type="text" class="form-control" id="notice_title" name="notice_title" aria-describedby="emailHelp"
    value="<?php echo $row['notice_title']?>">
    <input type="checkbox" name="notice_top" value="1"
    <?php 
    if ($row['notice_top'] == "1"){
    ?>checked
    <?php
    }?>>공지
  </div>

  <div class="form-group">
    <label for="notice_name"></label>
    <input type="text" class="form-control" id="notice_name" name="notice_name"aria-describedby="emailHelp"
    value="<?php echo $_SESSION['admin_id']?>">
  </div>

  <div class="form-group">
    <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
    <label for="notice_memo">내용</label>
    <textarea class="form-control" id="notice_memo" name="notice_memo" rows="5">
    <?php echo $row['notice_memo']?></textarea>
    <script type = "text/javascript">
      CKEDITOR.replace('notice_memo',{height:350});
    </script>
  </div>

  <div style="text-align:center">
  <button type="submit" class="btn btn-dark">글등록</button>
  <button type="reset" class="btn btn-dark">글취소</button>
  </div>

</form>
</div>
<!--공지사항 글 등록 끝-->



<!--푸터 시작-->
<?php
  include "../inc/footer.php"
?>
<!--푸터 끝-->

</body>
</html>
<?php
}
?>


