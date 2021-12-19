<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>회원가입페이지</title>
    <script>
     src="https://code.jquery.com/jquery-3.6.0.js"
     integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
     crossorigin="anonymous"></script>
    <script>
        function check_id() {
            
        }

        function checkid(){
            var user_id = document.getElementById("user_id").value;

            if(user_id)
            {
                url = "id_check.php?user_id="+user_id;
                        window.open(url,"chkid","width=300,height=100");
            } else {
                alert("아이디를 입력하세요");
            }
        }
    
        //비밀번호 일치 확인
        function checkpass(){ 
          var user_pass = document.getElementById("user_pass").value;
          var user_pass2 = document.getElementById("user_pass2").value;

          if (user_pass == user_pass2)  {
            alert("비밀번호가 일치합니다.");
          }
          else{
            alert("비밀번호 일치하지 않습니다. 확인해 주세요.");
          }
      }
     </script>
</head>
<body>
    
    <h1>회원가입</h1>
    
    <div class="wrap">
    <form action="register_ok.php" method="post" id="sign">
    <table>
        <tr>
            <td>id &nbsp;&nbsp;<input type="text" name="user_id" id ="user_id" placeholder="사용자아이디" required>
            <input type="submit" value="중복검사" onclick="checkid();"></td>
        </tr>

        <tr>
            <td>password &nbsp;&nbsp;<input type="password" name="user_pass" id="user_pass" placeholder="비밀번호" required></td>
        </tr>
        
        <tr>
            <td>password &nbsp;&nbsp;<input type="password" name="user_pass2" id="user_pass2" placeholder="비밀번호 확인" required>
            <input type="submit" value="비밀번호확인" onclick="checkpass();" ></td></td> 
            
        </tr>
       
        <tr>
            <td>name &nbsp;&nbsp;<input type="text" name="user_name" placeholder="사용자이름" required></td>
        </tr>
        
        <tr>
            <td>gender <input type="radio" name="user_gender" value="남자" checked>남자
                <input type="radio" name="user_gender" value="여자">여자</td>
        </tr>

        <tr>
            <td>phone &nbsp;&nbsp;
                <select class="phone" name="user_phone1">
                <option value="010">010</option>
                <option value="011">011</option>
                <option value="070">070</option>
            </select>
            &nbsp;-&nbsp; <input type="text" name="user_phone2" placeholder="4자리">
            &nbsp;-&nbsp; <input type="text" name="user_phone3" placeholder="4자리"></td>
        </tr>
        
        <tr>
            <td>e-mail &nbsp;&nbsp;<input type="text" name="user_mail1" placeholder="이메일">&nbsp;@&nbsp; 
                <select class="mail" name="user_mail2">
                    <option value="naver.com">naver.com</option>
                    <option value="gamil.com">gamil.com</option>
                    <option value="daum.com">daum.com</option>
                </select>
                <input type="submit" value="이메일인증" href="#"> </td>
        </tr>

        <!-- 이메일 인증
        https://sky17777.tistory.com/108
        -->

        <tr>
            <td><input type="submit" value="회원가입" style="font-size:20px;" ></td>
        </tr>
    </table>
    </form>
    </div>
    
</body>
</html>