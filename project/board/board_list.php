<?php
session_start();

include "../config/dbconnect.php";

if(isset($_GET['page'])){
  $page = $_GET['page']; //page의 값이 GET으로 넘어온 값이 있다면 그 값을 표시하고
} else {
  $page = 1; // 그렇지 않으면 1페이지이다.
}
$sql="select * from board";
$result = mysqli_query($con, $sql);
$row_num = mysqli_num_rows($result); //게시판 record 총 수(등록된 글 수)

$list = 3; //한 페이지에 보이는 글의 수를 $list변수로 지정
$block_ct = 3; //페이지 블록의 수를 $block_ct변수로 지정
$block_num = ceil($page / $block_ct); //현재 페이지 블록 ceil : 소수점 이하 버리고 +1을 해줌
$block_start = (($block_num - 1) * $block_ct) + 1;//블록의 시작번호
$block_end = $block_start + $block_ct - 1; //블록의 마지막 번호

$total_page = ceil($row_num / $list); //총 페이지 수 ceil 실수 값을 올리기

if($block_end > $total_page){
  $block_end = $total_page; //블록의 마지막 번호가 총 페이지 수보다 많다면 마지막 번호는 페이지 수
}

$total_block = ceil($total_page/$block_ct); //블록의 총 수

$start_num = ($page - 1) * $list; //시작번호

$number = $row_num - $start_num; //총 등록된 글 수 - 시작번호
?>


<!DOCTYPE html>
<html lang="ko">
<head>
  <title>Bootstrap 4 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  </style>
  
</head>
<body>

<!--헤더 시작-->
<?php
  include "../inc/header.php";
?>
<!--헤더 끝-->

<!--네비 시작-->
<?php
  //include "../inc/navi.php"
?>
<!--네비 끝-->

<!--갤러리 목록 시작-->
<div style="width:90%;margin:0 auto;text-align:center;">
  <div style="margin-top:50px;margin-bottom:50px;">
  <h1>My Diary</h1>
  <table>
    <tr>
      <td>현재 등록된 글은 <?php echo $row_num ?>건입니다.</td>
    </tr>
  </table>
  <table class="table">
    <thead class="thead-dark">
      <tr>
      <th scope="col" style="width:5%;text-align:center;">No</th>
        <th scope="col" style="width:25%;text-align:center;">Image</th>
        <th scope="col" style="width:45%;text-align:center;">Title</th>
        <th scope="col" style="width:10%;text-align:center;">Name</th>
        <th scope="col" style="width:15%;text-align:center;">Date</th>
      </tr>
    </thead>
    <tbody>
    <?php

    if($row_num > 0){


    $sql2 = "select * from board order by board_idx desc limit $start_num, $list";
    $result2 = mysqli_query($con, $sql2);
    //반복구문
    while($rows = mysqli_fetch_array($result2)){
    ?> 
      <tr>
        <th scope="row" style="width:5%;text-align:left;"><?php echo $number; ?></th>
        <th scope="row" style="width:25%;text-align:left;">
        <a href="board_view.php?board_idx=<?php echo $rows['board_idx'];?>">
        <?php 
        if($rows['file_copied_0'] == ""){
        }
        else{ 
        ?>
        <img src="board_upload/<?php echo $rows['file_copied_0'];?>" width="300" class="img-thumbnail"></th>
        <?php  
        $number--;
        }
        ?>

        <?php
        $title = $rows['board_title'];
        if(strlen($title) > 25){ //strlen : 자릿수
          $title = str_replace($rows['board_title'],mb_substr($rows['board_title'],0,25,"utf-8")."...",$rows['board_title']);
        }
        
        //$wdate = $rows['board_wdate'];
        //$timenow = date("Y-m-d");

        ?>

        <td style="width:45%;text-align:left;"><a href="board_view.php?board_idx=<?php echo $rows['board_idx'];?>">
        <?php echo $title;?></a>
        <?php
        if(time() - strtotime($rows['board_wdate']) <= 60 * 60 * 24 * 2){
          //time : 1970.1.1 오전 9시부터 현재까지의 초
          //strtotime : 등록된 시간을 초로 환산
        ?>
        new
        <?php
        }
        ?>
        </td>
        
        <td style="width:10%;text-align:center;">
        <a href="board_view.php?board_idx=<?php echo $rows['board_idx'];?>">
        <?php echo $rows['board_name'];?>
        </td>
        
        <td style="width:15%;text-align:center;"><?php echo substr($rows['board_wdate'],0,10);?></td>
        <td style="width:7%;text-align:center;"><?php echo $rows['board_hit'];?></td>
      </tr>
    <?php
    }
    }else{
      ?>
      <tr>
        <td colspan="5" style="text-align:center;">등록된 게시물이 없습니다.</td>
      </tr>
    <?php
    }
    ?>
    </tbody>
  </table>
  </div>
  <!--갤러리 목록 끝-->

  <!--알림창 구문 시작-->
  <script>
    function a()
    {
      alert('첫번째 페이지 입니다.');
    }
    
    function b()
    {
      alert('마지막 페이지 입니다.');
    }
  </script>
  <!--알림창 구문 끝-->

  <!--페이지 블록 시작-->
  <div style="text-align:center;">
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <!--맨 앞으로 가기 시작-->
        <li class="page-item">
        <?php
        if($page <= 1){
          echo "<a class='page-link' href='#' onclick='a()' aria-label='Previous'>
          <span aria-hidden='true'>&laquo;</span>
          </a>";
        } else {
          echo "<a class='page-link' href='?page=1' aria-label='Previous'>
          <span aria-hidden='true'>&laquo;</span>
          </a>";
        }
        ?>
        </li>
        <!--맨 앞으로 가기 끝-->

        <!--이전으로 가기 시작-->
        <li class="page-item">
        <?php
        if($page <= 1){
        } else {
          $pre = $page - 1;
          echo "<a class='page-link' href='?page=$pre' aria-label='Previous'>
          <span aria-hidden='true'>&lt;</span>
          </a>";
        }
        ?>
        </li>
        <!--이전으로 가기 끝-->

        <?php
          for($i=$block_start;$i<=$block_end;$i++){
            if($page == $i){
              echo "<li class='page-item active'>
              <a class='page-link'>$i</a></li>";
            } else {
              echo "<li class='page-item'>
              <a class='page-link' href='?page=$i'>$i</a></li>";
            }
          }
          ?>
          
        <!--다음으로 가기 시작-->
        <li class="page-item">
        <?php
        if(($block_num >= $total_block) && ($block_num < $total_block)){ //현재블록이 블록의 총 개수보다 크거나 같다면
        } else {
          $nex = $page + 1;
          echo "<a class='page-link' href='?page=$nex' aria-label='Next'>
          <span aria-hidden='true'>&gt;</span>
        </a>";
        }
        ?>
        </li>
        <!--다음으로 가기 끝-->

        <!--맨 끝으로 가기 시작-->
        <li class="page-item">
        <?php
        if($page >= $total_page) {
          echo "<a class='page-link' href='#' onclick='b()' aria-label='Next'>
          <span aria-hidden='true'>&raquo;</span>
        </a>";
        } else {
          echo "<a class='page-link' href='?page=$total_page' aria-label='Next'>
          <span aria-hidden='true'>&raquo;</span>
        </a>";
        }
        ?>
        </li>
        <!--맨 끝으로 가기 끝-->
      </ul>
    </nav>
  </div>
  <!--페이지 블록 끝-->

  <!--글쓰기 버튼-->
  <div style="margin-bottom:100px; text-align:right;">
  <a class="btn btn-dark" href="board_write.php" role="button">글쓰기</a>
  </div>
</div>

<!--푸터 시작-->
<?php
  include "../inc/footer.php"
?>
<!--푸터 끝-->

</body>
</html>
