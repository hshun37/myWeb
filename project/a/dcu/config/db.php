<?php
session_start();


//세션 / 쿠키
  $db=new mysqli("localhost","root","autoset","web");
	//DB주소, DB아이디, DB비밀번호, 데이터베이스 이름
 
  
  
  /* 아래 소스를 쓰면 sql문의 실행 명령어를 사용하지 않아도 된다. */
  /*$db->set_charset("utf8");
  
  function mq($sql){
	global $db;
	return $db-> query($sql);
	
  }*/




?>