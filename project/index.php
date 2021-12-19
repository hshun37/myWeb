<?php
session_start();
include "config/dbconnect.php";

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
  a:link{
    color: black;
    text-decoration-line: none;
  }
  a:visited{
    color: black;
  }
  a:hover{
    color: #aaa;
  }
  #nav-item:hover{
    background-color:blue;
  }
  </style>
  
</head>
<body>

<!--헤더 시작-->
<?php
  include "inc/header1.php";
?>
<!--헤더 끝-->

<!--네비 시작-->
<?php
  //include "inc/navi1.php"
?>
<!--네비 끝-->

<!--메인이미지-->
<div id="wrap" style="border:1px solid gray; margin:auto; margin-top:40px; width:1200px; height:600px;">
<div class="row">
  <div class="col-sm-2" style="margin-left:36px; margin-top:80px;">
    <?php
    include "inc/main_image.php"
    ?>
  </div>
  <div class="col-sm-4" style="margin-top:220px;">
    <?php
    include "inc/main_image.php"
    ?>
  </div>
  
  <div class="col-sm-5" style="margin:auto; margin-top:70px;">
    <?php
    include "inc/calendar.php"
    ?>
  </div>
</div>
  
</div>
<!--메인이미지 끝-->

<!--본문1 시작-->
<div class="container" style="margin-top:50px; border:1px solid black;">
  <div class="row">
    <div class="col-sm-4" style="width:1100px; height:230px;">

    </div>

  </div>
</div>
<!--본문1 끝-->

<!--카드 본문 시작-->
<div class="container" style="margin:auto;margin-top:50px;margin-bottom:50px;">

  </div>
<!--카드 본문 끝-->


<!--푸터 시작-->
<?php
  include "inc/footer.php"
?>
<!--푸터 끝-->

</body>
</html>
