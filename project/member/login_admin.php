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
  include "../inc/navi.php"
?>
<!--네비 끝-->

<!--로그인 시작-->
<div class="container" style="margin-top:100px;margin-bottom:100px;">
<h1>Login</h1>

<form method="post" action="login_admin_ok.php">
  <div class="form-group">
    <label for="exampleInputEmail1">ID</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="admin_id">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="admin_pass">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<!--로그인 끝-->



<!--푸터 시작-->
<?php
  include "../inc/footer.php"
?>
<!--푸터 끝-->

</body>
</html>
