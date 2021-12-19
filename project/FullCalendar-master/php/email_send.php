<?php

require "./PHPMailer/src/PHPMailer.php";
require "./PHPMailer/src/SMTP.php";
require "./PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class emailController
{
    private $title, $description, $start, $end;

    public function __construct($title, $description, $start, $end)
    {
        $this->title = $title;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
    }

    public function __destruct()
    {

    }
    public function startMailing()
    {
        try {

            // 서버세팅
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0; // 디버깅 설정 2
            $mail->isSMTP(); // SMTP 사용 설정

            $mail->Host = "smtp.gmail.com"; // email 보낼때 사용할 서버를 지정
            $mail->SMTPAuth = true; // SMTP 인증을 사용함
            $mail->Username = ""; // 메일 계정
            $mail->Password = ""; // 메일 비밀번호
            $mail->SMTPSecure = "ssl"; // SSL을 사용함
            $mail->Port = 465; // email 보낼때 사용할 포트를 지정
            $mail->CharSet = "utf-8"; // 문자셋 인코딩

            // 보내는 메일
            $mail->setFrom("", ""); //메일주소 , 별칭

            // 받는 메일
            $mail->addAddress("", ""); //메일주소 , 별칭
            // $mail -> addAddress("yinglong200@naver.com", "receive02");

            // 첨부파일
            // $mail -> addAttachment("./test.zip");
            // $mail -> addAttachment("./anjihyn.jpg");

            // 메일 내용
            $mail->isHTML(true); // HTML 태그 사용 여부
            $mail->Subject = ""; // 메일 제목
            $mail->Body = ""; // 메일 내용 HTML 코드 사용 가능

            // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
            // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
            $mail->SMTPOptions = array(
                "ssl" => array(
                    "verify_peer" => false
                    , "verify_peer_name" => false
                    , "allow_self_signed" => true,
                ),
            );

            // 메일 전송
            $mail->send();
            //echo "Message has been sent";

        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error : ", $mail->ErrorInfo;
        }
    }
}
