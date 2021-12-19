<?php
    include "../common/session.php";
    include "../common/checkSignSession.php";
    include "../db/dbCon.php";

    if(isset($_GET['boardID']) && (int) $_GET['boardID'] > 0) {
        $boardID = $_GET['boardID'];
        $sql = "select b.title, b.content, m.nickname, b.regTime from board b
            join member m on (b.memberID = m.memberID) where b.boardID = {$boardID}";
            $result = $dbConnect -> query($sql);

        if($result) {
            $contentInfo = $result -> fetch_array(MYSQLI_ASSOC);
            echo "제목 : " . $contentInfo['title']. "<br>";
            echo "작성자 : " . $contentInfo['nickname'] . "<br>";
            $regDate = date("Y-m-d h:i");
            echo "게시일 : {$regDate}<br><br>";
            echo "내용 : <br>";
            echo $contentInfo['content'].'<br><br>';
            echo "<a href='./list.php'>목록으로 이동</a>";
        } else {
            echo "잘못된 접근입니다.";
            exit;
        }
    } else {
        echo "잘못된 접근입니다.";
        exit;
    }
?>