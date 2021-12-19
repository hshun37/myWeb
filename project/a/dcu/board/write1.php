<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<!--초기화 css-->
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<!--레이아웃 css-->
	<link rel="stylesheet" type="text/css" href="../css/layout.css">

	
</head>
<body>
	<div id="wrap">
		<?php
		include "../inc/header.html";
		?>
		<div>
			<form method="post" action="write_ok.php" name="frm">
				<input type="hidden" name="userid" value="aassddff">
				제목 : <input type="text" name="title" placeholder="제목을 입력하세요">
				<input type="checkbox" name="secret" value="1" checked>비밀글
				<br>	
				이름 : <input type="text" name="name" placeholder="이름을 입력하세요"><br>
				이메일 : <input type="text" name="email" placeholder="이메일을 입력하세요"><br>
				<textarea name="content" style="width: 100%;"></textarea>
				<input type="password" name="password" placeholder="비밀번호를 입력하세요">
				<input type="submit" value="글쓰기">
			</form>
		</div>
	</div>

</body>
</html>