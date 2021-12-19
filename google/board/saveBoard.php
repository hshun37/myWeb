<?php
    include "../db/dbCon.php";
    include "../common/session.php";
    include "../common/checkSignSession.php";

    $title = $_POST['title'];
    $content = $_POST['content'];

    if($title != null || $title != '') {
        $title = $dbConnect -> real_escape_string($title);
    } else {
        echo "제목을 입력하세요.";
        echo "<a href ='./writeForm.php'>작상페이지로 이동</a>";
        exit;
    }

    if($content != null || $content != '') {
        $content = $dbConnect -> real_escape_string($content);
    } else {
        echo "내용을 입력하세요.";
        echo "<a href ='./writeForm.php'>작상페이지로 이동</a>";
        exit;
    }

    $memberID = $_SESSION['memberID'];

    $regTime = time();

    $sql = "insert into board (memberID, title, content, regTime) values
             ('{$memberID}', '{$title}', '{$content}', '{$regTime}')";
    $result = $dbConnect -> query($sql);

    if($result) {
        echo "저장 완료";
        echo "<a href='./list.php'>게시글 목록으로 이동</a>";
        exit;
    } else {
        echo "저장 실패 - 관리자에게 문의";
        echo "<a href='./list.php'>게시글 목록으로 이동</a>";
        exit;
    }
?>