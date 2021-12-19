<!doctype html>
<html>
<head>
<body>
    <h1>로그인</h1>
    <form action="./signInProcessing.php" name="signIn" method="POST">
        이메일<br>
        <input type="email" name="userEmail">
        <br>
        <br>
        비밀번호<br>
        <input type="password" name="userPw">
        <br>
        <br>
        <input type="submit" value="로그인">
        <br>
        <br>
        <a href="./signUpForm.php">회원가입</a>
        <a href="../index.php">메인페이지</a>
    </form>
</body>
</head>
</html>