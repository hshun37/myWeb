<?php
    include "../common/session.php";
    include "../common/checkSignSession.php";
    include "../db/dbCon.php";
?>

<!doctype html>
<html>
<head>
    <title>게시물 목록</title>
</head>
<body>
    <table>
        <thead>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>게시일</th>
        </thead>
        <tbody>
            <?php
                if(isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }

                $numView = 20;
                $firtsLimitValue = ($numView * $page) - $numView;

                $sql = "select b.boardID, b.title, m.nickname, b.regTime from board b 
                join member m on (b.memberID = m.memberID) order by boardID
                desc limit {$$firtsLimitValue} {$numView}";

                $result = $dbConnect -> query($sql);

                if($result) {
                    $dataCount = $result -> num_rows;
                    if($dataCount > 0) {
                        for ($i = 0; $i < $dataCount; $i++) { 
                            $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);
                            echo "<tr>";
                            echo "<td>".$memberInfo['boardID']."</td>";
                            echo "<td><a href = './view.php?boardID=";
                            echo "{$memberInfo['boardID']}'>";
                            echo $memberInfo['title'];
                            echo "</a></td>";
                            echo "<td>{$memberInfo['nickname']}</td>";
                            echo "<td>".date('Y-m-d H:i', $memberInfo['regTime'])."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>게시글이 없습니다.</td><tr>";
                    }
                }
            ?>
        </tbody>
    </table>
    <br>
    <br>
    <a href="../index.php">메인페이지</a>
    <a href="./writeForm.php">글작성하기</a>
    <a href="../sign/signOut.php">로그아웃</a>
</body>
</html>