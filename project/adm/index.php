<?php
session_start();
include "../config/dbconnect.php";
?>
<!--부트스트랩-->
<!doctype html>
<html lang="ko">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>관리자 모드</title>
  </head>
  <body>
  <?php  
  if(!isset($_SESSION['admin_id'])){ //SESSION값이 없다면
  ?>
    <h1>관리자 모드</h1>

    <form method="post" action="adm_ok.php"> <!--submit시에 adm_ok.php로 넘어가기-->
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="admin_id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="admin_pass" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
    <?php
    } else {

      $sql = "select * from board order by b_idx desc limit 0, 5"; //최근 글 5개만 노출
      $result = mysqli_query($con, $sql);
    ?>
    <?php echo $_SESSION['admin_name'];?>(레벨 : <?php echo $_SESSION['admin_level'];?>)님께서 접속하였습니다.
    <a href = "log_out.php">로그아웃</a>
    <br>

    <div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col"><input type="checkbox"></th>
            <th scope="col">제목</th>
            <th scope="col">이름</th>
            <th scope="col">날짜</th>
            <th scope="col">관리</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($result)) {?>
          <tr>
            <th scope="row"><input type="checkbox"></th>
            <td><?php echo $row['b_title']?></td>
            <td><?php echo $row['b_name']?></td>
            <td><?php echo $row['b_wdate']?></td>
            <td><a href="#">삭제</a></td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php
    }
    ?>
  </body>
</html>