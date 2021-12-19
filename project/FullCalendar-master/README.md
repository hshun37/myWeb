# FullCalendar
- 참조 1번님의 FullCalendar 예제/데모 에서 JSON 파일이 아닌 DB 연동으로 소스 변경   
  필요에 의해 급하게 만든거라 버그가 있을 수 있음.
- Code에 보면 calendar.sql 파일이 있는데, 이는 MYSQL 테이블 생성 명령이 있음.
- DB연동부분은 DBController.php 부분에 있음.

## 개발환경
- JavaScript, css, bootstrap4, FullCalendar, PHP, MYSQL(MariaDB)

## 참조
- https://kutar37.tistory.com/entry/FullCalendar-%EC%98%88%EC%A0%9C%EB%8D%B0%EB%AA%A8
- https://fullcalendar.io/

## 화면
![Alt text](https://github.com/LeeChiWon/FullCalendar/blob/master/demo.png)

## 업데이트 내역
### Rev1.0.0
- 일정 추가시 메일 전송 기능 추가 (PHPMailer 사용)
- 일정 삭제시 한번만 삭제되었던 오류 
