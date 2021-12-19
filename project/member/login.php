<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/login.css">
    <title>로그인페이지</title>
</head>
<body>
    <div class="login_page">
		<h1>Login</h1>
			<div class="index_login">
			<form method="post" action="login_ok.php">
			
				<p><input type="text" name="user_id" placeholder="  아이디를 입력하세요."
				required></p>
				<p><input type="password" name="user_pass" placeholder="  비밀번호를 입력하세요."
				required></p>
				<p><input type="submit" value="로그인"></p>
			
				<button><a href="../member/register.php">회원가입</a></button>
				<button><a href="../index.php">Diary</a></button>
			
			</form>
			</div>
		</div>
    </div>
</body>
</html>