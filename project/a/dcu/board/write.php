<!DOCTYPE html>
<html lang="ko">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
  <link rel="stylesheet" href="../css/common.css">
  <!--레이아웃 관련 css-->
  <link rel="stylesheet" href="../css/layout.css">
 </head>
 <body>
 <div id="wrap">

 	<?php
	include "../inc/header.html";


	?>
	<div>
	<form method="post" action="write_ok.php" name="frm">
	<input type="hidden" name="userid" value="test1">
		제목 : <input type="text" name="title" placeholder="제목을 입력하세요">
		<input type="checkbox" name="secrit" value="1" checked>비밀글
		<br>
		이름 : <input type="text" name="name" placeholder="이름을 입력하세요" value="<?php echo $_SESSION['user_name']?>"><br>
		이메일 : <input type="text" name="email" placeholder="이메일을 입력하세요" value="<?php echo $_SESSION['user_email']?>"><br>
		<textarea name="content" style="width:100%">
		</textarea>
		<input type="password" name="pass" placeholder="비밀번호를 입력하세요"><br>
		<input type="submit"value="글쓰기">
	</form>
	</div>
 </div>
  
 </body>
</html>
