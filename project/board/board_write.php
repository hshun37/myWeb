<?php
session_start();

include "../config/dbconnect.php";

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
  //include "../inc/navi.php"
?>
<!--네비 끝-->

<!--갤러리 글 등록-->
<div class="container" style="margin-top:100px;margin-bottom:100px;">
<h1>Gallery</h1>


<form method="post" action="board_write_ok.php" enctype="multipart/form-data"> <!--enctype="multipart/from-data" : 사진과 text가 같이 들어가게 함-->
  <?php
  if(!isset($_SESSION['user_id'])){
  } else {
  ?>
  <input type="hidden" name="board_name" value="<?php echo $_SESSION['user_name']?>">
  <input type="hidden" name="board_email" value="<?php echo $_SESSION['user_email']?>">
  <input type="hidden" name="board_id" value="<?php echo $_SESSION['user_id']?>">
  <?php
  }
  ?>
  <div class="form-group">
    <label for="board_title">제목</label>
    <input type="text" class="form-control" id="board_title" name="board_title" aria-describedby="emailHelp">
  </div>
  
  <?php
  if(!isset($_SESSION['user_id'])){
  ?>  
  <div class="form-group">
    <label for="board_pass">비밀번호</label>
    <input type="password" class="form-control" id="board_pass" name="board_pass">
  </div>

  <div class="form-group">
    <label for="board_name">작성자</label>
    <input type="text" class="form-control" id="board_name" name="board_name"aria-describedby="emailHelp">
  </div>

  <div class="form-group">
    <label for="board_email">이메일</label>
    <input type="email" class="form-control" id="board_email" name="board_email" aria-describedby="emailHelp">
  </div>
  <?php
  }
  ?>
  <div class="form-group">
    <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
    <label for="board_content">일기장</label>
    <textarea class="form-control" id="board_content" name="board_content" rows="5"></textarea>
    <script type = "text/javascript">
      CKEDITOR.replace('board_content',{height:350});
    </script>
  </div>

  <div class="form-group">
    <label for="board_file1">사진첨부</label>
    <input type="file" class="form-control-file" id="board_file1" name="upfile[]">
  </div>
  
  <div style="text-align:center">
  <button type="submit" class="btn btn-dark">글등록</button>
  <button type="reset" class="btn btn-dark">글취소</button>
  </div>

</form>
</div>
<!--갤러리 글 등록 끝-->



<!--푸터 시작-->
<?php
  include "../inc/footer.php"
?>
<!--푸터 끝-->

</body>
</html>
