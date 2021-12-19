<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<!--초기화 css-->
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<!--레이아웃 css-->
	<link rel="stylesheet" type="text/css" href="../css/layout.css">
	<!--로그인 css-->
	<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
	<!--전체 구조-->
	<div>
		<?php
		include "../inc/header.html";
		?>
		<!--로그인 창-->
		<div class="login_wrap">
			<h1>로그인</h1>
			<div class="index_login">
				<form method="post" action="login_ok.php">
					<ul>
						<li><input type="text" name="user_id" placeholder="아이디를 입력하세요" required></li>
						<li><input type="password" name="user_pass" placeholder="비밀번호를 입력하세요" required></li>
						<li><input type="submit" name="로그인"></li>
					</ul>
					<ul>
						<li><a href="member.php">회원가입</a></li>
					</ul>
				</form>
			</div>
		</div>
		<!--로그인 끝-->
	</div>
	<!--전체 구조 끝-->
</body>
</html>