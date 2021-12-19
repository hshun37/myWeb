<?php
    include "../common/session.php";
    include "../db/dbCon.php";

    $email = $_POST['userEmail'];
    $pw = $_POST['userPw'];

    function goSignUpPage($alert) {
        echo $alert.'<br>';
        echo "<a href = './sign.php'>로그인 폼으로 이동</a>";
        return;
    }

    //유효성 검사
    //이메일 검사
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        goSignUpPage('올바른 이메일이 아닙니다.');
        exit;
    }

    //비밀번호 검사
    if($pw == null || $pw == '') {
        goSignUpPage('비밀번호를 입력해 주세요.');
        exit;
    }

    $pw = sha1('php200'.$pw);

    $sql .= "select email, nickname, memberID from member where email = '{$email}' and password = '{$pw}'";
    $result = $dbConnect -> query($sql);

    if($result) {
        if($result -> num_rows == 0) {
            goSignUpPage('로그인 정보가 일치하지 않습니다.');
            exit;
        } else {
            $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);
            $_SESSION['memberID'] = $memberInfo['memberID'];
            $_SESSION['nickName'] = $memberInfo['nickname'];
            //echo $_SESSION['nickName'];
            Header("Location:../index.php");
        }
    }
?>