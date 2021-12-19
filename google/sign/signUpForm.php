<!doctype html>
<html lang="ko">
<head>
<title>회원가입</title>
</head>
<body>
    <h1>회원가입</h1>
    <form action="./signUpSave.php" name="signUp" method="POST">
    이메일<br>
    <input type="email" name="userEmail">
    <br>
    <br>
    닉네임<br>
    <input type="text" name="userNickName">
    <br>
    <br>
    비밀번호<br>
    <input type="password" name="userPw">
    <br>
    <br>
    생일<br>
    <select name="birthYear">
        <?php
        $tihsYear = date('Y', time());
        for($i = $tihsYear; $i >= 1930; $i--) {
            echo "<option value='{$i}'>{$i}</option>";
        }
        ?>
    </select>년
    <select name="birthMonth">
        <?php
         for($i = 1; $i <= 12; $i++) {
            echo "<option value='{$i}'>{$i}</option>";
        }
        ?>
    </select>월
    <select name="birthDay">
        <?php
         for($i = 1; $i <= 31; $i++) {
            echo "<option value='{$i}'>{$i}</option>";
        }
        ?>
    </select>일
    <br>
    <br>
    <input type="submit" value="가입하기">
    <br>
    <br>
    <a href="./sign.php">로그인 </a>
    <a href="../index.php"> 메인페이지</a>
    </form>
</body>
</html>