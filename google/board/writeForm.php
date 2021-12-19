<?php
    //include "../common/checkSignSession.php";
    include "../common/session.php";
?>

<!doctype html>
<html>
<head>
</head>
<body>
    <form name="boardWrite" method="POST" action="./saveBoard.php">
    제목
    <br>
    <br>
    <input type="text" name="title">
    <br>
    <br>
    내용
    <br>
    <br>
    <textarea name="content" cols="80" rows="10"></textarea>
    <br>
    <br>
    <input type="submit" value="저장">
    </form>
    <br>
    <br>
    <a href="./list.php">리스트보러가기</a>
</body>
</html>