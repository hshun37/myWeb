<?php
include "../config/dbconnet.php";
// include "../password/password.php";

$user_id=$_POST['user_id'];
$user_pass=password_hash($_POST['user_pass'],PASSWORD_DEFAULT); //비밀번호 암호화
$user_pass2=password_hash($_POST['user_pass2'],PASSWORD_DEFAULT);
$user_name=$_POST['user_name'];
$user_gender=$_POST['user_gender'];

$user_phone1=$_POST['user_phone1']; //전화번호 맨앞자리
$user_phone2=$_POST['user_phone2']; //전화번호 두번째자리
$user_phone3=$_POST['user_phone3']; //전화번호 세번째자리
$user_phone= $user_phone1."-".$user_phone2."-".$user_phone3;   
//전화번호 모두 합쳐서 db에는 user_phone 이라는 하나의 컬럼으로만 저장

$user_mail1=$_POST['user_mail1'];   //이메일 아이디
$user_mail2=$_POST['user_mail2'];   //이메일 주소
$user_mail= $user_mail1 . "@" . $user_mail2;
//이메일 합쳐서 db에는 user_mail 이라는 하나의 컬럼으로만 저장

$user_date = date('Y-m-d H:i');

//회원 중복처리
$sql1="SELECT * FROM register WHERE user_id='".$user_id."'";
$result1= mysqli_query($db, $sql1);
$row = mysqli_fetch_array($result1);

if($row==0) {

$sql = "INSERT INTO register
(user_id,user_pass,user_pass2,user_name,user_gender,user_phone,user_mail,user_date)
VALUES ('".$user_id."','".$user_pass."','".$user_pass2."','".$user_name."','".$user_gender."','".
$user_phone."','".$user_mail."','".$user_date."')";


$result = mysqli_query($db, $sql);

?>
<script>
alert("회원가입이 완료.\n로그인하시기 바랍니다.");
location.href="../project/login.php";
</script>

<?php
} else {
?>

<script>
alert("증복된 아이디가 있습니다.\n다시 입력하세요.");
history.back();
</script>
<?php
}

?>