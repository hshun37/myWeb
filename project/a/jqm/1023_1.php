<?php
session_start();
include "../config/db.php";
?>
<!DOCTYPE html>
<html lang="ko">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Document</title>
 <!--Jquery mobile-->
 <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
 <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
 <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
 
 </head>
 <body>
 	<!--page1-->
 	<!--전체 문서 시작-->
	<div data-role="page" id="page1">
		<!--헤더 시작-->
		<div data-role="header" data-fullscreen="true" data-position="fixed" data-theme="b">
			<a href="#page1" class="ui-btn-left">홈</a>
			<h1>logo</h1>
			<a href="#page2" class="ui-btn-right">다음</a>
			<div data-role="navbar">
				<ul>
					<li><a href="#" class="ui-btn-active">메뉴1</a></li>
					<li><a href="#page2">메뉴2</a></li>
					<li><a href="#page3">메뉴3</a></li>
					<li><a href="#page4">메뉴4</a></li>
					<li><a href="#page5">메뉴5</a></li>
				</ul>
			</div>
		</div>
		<!--헤더 끝-->

		<!--본문 시작-->
		<div data-role="content">
			<h2>외부링크</h2>
			<ul data-role="listview" data-inset="true">
				<li><a href="mailto:whtjdrms1282@naver.com">이메일링크</a></li>
				<li><a href="tel:01027497712">전화링크</a></li>
				<li><a href="sms:01027497712">문자링크</a></li>
				<li><a href="https://www.google.com/maps/@35.9133361,128.8032156,18.25z?hl=ko">주소링크</a></li>
			</ul>
		</div>
		<!--본문 끝-->

		<!--푸터 시작-->
		<div data-role="footer" data-fullscreen="true" data-position="fixed" data-theme="b">
			<div data-role="navbar">
				<ul>
					<!--
					<li><a href="#" data-icon="home">홈</a></li>
					-->
					<li><a href="#panel1" data-icon="check">로그인</a></li>
					<li><a href="#" data-icon="calendar">일정</a></li>
					<li><a href="#" data-icon="camera">사진</a></li>
					<li><a href="#panel2" data-icon="gear">설정</a></li>
				</ul>
			</div>
		</div>
		<!--푸터 끝-->
			
		<!--패널 시작-->
		<div data-role="panel" data-display="overlay" id="panel1" data-theme="b">
			<form>
				<h3>로그인</h3>
				
				<label for="name">사용자명 : </label>
				<input type="text" name="name" id="name">

				<label for="password">비밀번호 : </label>
				<input type="password" name="password" id="password">
				
				<div class="ui-grid-a">
					<div class="ui-block-a"><a href="#" data-role="button">저장</a></div>
					<div class="ui-block-b"><a href="#" data-role="button">취소</a></div>
				</div>
			</form>
		</div>

		<div data-role="panel" data-display="overlay" id="panel2" data-position="right">
			<h1>panel2</h1>
		</div>
		<!--패널 끝-->
	</div>
	<!--전체 문서 끝-->
	
	<!--page2-->
	<!--전체 문서 시작-->
	<div data-role="page" id="page2">
		<!--헤더 시작-->
		<div data-role="header" data-add-back-btn="true" data-back-btn-text="메인으로">
			<a href="#page1" class="ui-btn-left">홈</a>
			<h1>logo</h1>
			<a href="#page3" class="ui-btn-right">다음</a>
			<div data-role="navbar">
				<ul>
					<li><a href="#" class="ui-btn-active">메뉴1</a></li>
					<li><a href="#page2">메뉴2</a></li>
					<li><a href="#page3">메뉴3</a></li>
					<li><a href="#page4">메뉴4</a></li>
					<li><a href="#page5">메뉴5</a></li>
				</ul>
			</div>
		</div>
		<!--헤더 끝-->

		<!--본문 시작-->
		<div data-role="content">
			<p>고객명</p>
			<ul data-role="listview" data-filter="true" data-filter-placeholder="검색">
				<li data-role="listdivider">ㄱ</a></li>
				<li><a href="#">김민수</a></li>
				<li><a href="#">강민혁</a></li>
				<li data-role="listdivider">ㄴ</a></li>
				<li><a href="#">나희진</a></li>
				<li><a href="#">나윤경</a></li>
				<li data-role="listdivider">ㄷ</a></li>
				<li><a href="#">두만강</a></li>
				<li><a href="#">도민정</a></li>

			</ul>
		</div>
		<!--본문 끝-->

		<!--푸터 시작-->
		<div data-role="footer" data-fullscreen="true" data-position="fixed" data-theme="b">
			<div data-role="navbar">
				<ul>
					<li><a href="#" class="ui-btn-active">메뉴1</a></li>
					<li><a href="#page2">메뉴2</a></li>
					<li><a href="#page3">메뉴3</a></li>
					<li><a href="#page4">메뉴4</a></li>
					<li><a href="#page5">메뉴5</a></li>
				</ul>
			</div>
			<div data-role="navbar">
				<ul>
					<!--
					<li><a href="#" data-icon="home">홈</a></li>
					-->
					<li><a href="#panel1" data-icon="check">로그인</a></li>
					<li><a href="#" data-icon="calendar">일정</a></li>
					<li><a href="#" data-icon="camera">사진</a></li>
					<li><a href="#panel2" data-icon="gear">설정</a></li>
				</ul>
			</div>
		</div>
		<!--푸터 끝-->
	</div>
	<!--전체 문서 끝-->

	<!--page3-->
	<!--전체 문서 시작-->
	<div data-role="page" id="page3">
		<!--헤더 시작-->
		<div data-role="header" data-add-back-btn="true" data-back-btn-text="메인으로">
			<a href="#page1" class="ui-btn-left">홈</a>
			<h1>logo</h1>
			<a href="#page4" class="ui-btn-right">다음</a>
			<div data-role="navbar">
				<ul>
					<li><a href="#" class="ui-btn-active">메뉴1</a></li>
					<li><a href="#page2">메뉴2</a></li>
					<li><a href="#page3">메뉴3</a></li>
					<li><a href="#page4">메뉴4</a></li>
					<li><a href="#page5">메뉴5</a></li>
				</ul>
			</div>
		</div>
		<!--헤더 끝-->

		<!--본문 시작-->
		<div data-role="content">
			<p>내용</p>
			<div data-role="tabs">
				<div data-role="navbar">
					<ul>
						<li><a href="#tab1">탭1</a></li>
						<li><a href="#tab2">탭2</a></li>
						<li><a href="#tab3">탭3</a></li>
					</ul>
				</div>
				<div id="tab1">
				<h1>탭1</h1>
				<p>탭1내용</p>
				</div>

				</div>
				<div id="tab2">
				<h1>탭2</h1>
				<p>탭2내용</p>
				</div>

				</div>
				<div id="tab3">
				<h1>탭3</h1>
				<p>탭3내용</p>
				</div>
			</div>
		</div>
		<!--본문 끝-->

		<!--푸터 시작-->
		<div data-role="footer" data-fullscreen="true" data-position="fixed" data-theme="b">
			<div data-role="navbar">
				<ul>
					<!--
					<li><a href="#" data-icon="home">홈</a></li>
					-->
					<li><a href="#panel1" data-icon="check">로그인</a></li>
					<li><a href="#" data-icon="calendar">일정</a></li>
					<li><a href="#" data-icon="camera">사진</a></li>
					<li><a href="#panel2" data-icon="gear">설정</a></li>
				</ul>
			</div>
		</div>
		<!--푸터 끝-->
	</div>
	<!--전체 문서 끝-->

	<!--page4-->
	<!--전체 문서 시작-->
	<div data-role="page" id="page4">
		<!--헤더 시작-->
		<div data-role="header" data-add-back-btn="true" data-back-btn-text="메인으로">
			<a href="#page1" class="ui-btn-left">홈</a>
			<h1>logo</h1>
			<a href="#page4" class="ui-btn-right">다음</a>
			<div data-role="navbar">
				<ul>
					<li><a href="#" class="ui-btn-active">메뉴1</a></li>
					<li><a href="#page2">메뉴2</a></li>
					<li><a href="#page3">메뉴3</a></li>
					<li><a href="#page4">메뉴4</a></li>
					<li><a href="#page5">메뉴5</a></li>
				</ul>
			</div>
		</div>
		<!--헤더 끝-->

		<!--본문 시작-->
		<div data-role="content">
			<p>내용</p>
			<div data-role="collapsible">
				<h3>패널 제목1</h3>
				<p>패널 내용1</p>
				<div data-role="collapsible">
					<h3>내부 패널 제목1</h3>
					<p>내부 패널 내용1</p>
				</div>
			</div>

			<div data-role="collapsible">
				<h3>패널 제목1</h3>
				<p>패널 내용1</p>
			</div>
		</div>
		<!--본문 끝-->

		<!--푸터 시작-->
		<div data-role="footer" data-fullscreen="true" data-position="fixed" data-theme="b">
			<div data-role="navbar">
				<ul>
					<!--
					<li><a href="#" data-icon="home">홈</a></li>
					-->
					<li><a href="#panel1" data-icon="check">로그인</a></li>
					<li><a href="#" data-icon="calendar">일정</a></li>
					<li><a href="#" data-icon="camera">사진</a></li>
					<li><a href="#panel2" data-icon="gear">설정</a></li>
				</ul>
			</div>
		</div>
		<!--푸터 끝-->
	</div>
	<!--전체 문서 끝-->

	<!--page5-->
	<!--전체 문서 시작-->
	<div data-role="page" id="page5">
		<!--헤더 시작-->
		<div data-role="header" data-add-back-btn="true" data-back-btn-text="메인으로">
			<a href="#page1" class="ui-btn-left">홈</a>
			<h1>logo</h1>
			<a href="#page4" class="ui-btn-right">다음</a>
			<div data-role="navbar">
				<ul>
					<li><a href="#" class="ui-btn-active">메뉴1</a></li>
					<li><a href="#page2">메뉴2</a></li>
					<li><a href="#page3">메뉴3</a></li>
					<li><a href="#page4">메뉴4</a></li>
					<li><a href="#page5">메뉴5</a></li>
				</ul>
			</div>
		</div>
		<!--헤더 끝-->

		<!--본문 시작-->
		<div data-role="content">
			<p>내용</p>
		<?php 
			$sql = "select * from board order by b_idx desc limit 0,5";
			$result = mysqli_query($db, $sql);
			while($row = mysqli_fetch_array($result)){
		?>

			<div data-role="collapsible">
				<h3><?php echo $row['b_title'];?></h3>
				<p><?php echo $row['b_name'];?></p>
				<p><?php echo $row['b_wdate'];?></p>
				<p><?php echo $row['b_content'];?></p>
			</div>
			<p><?php
			if($row['b_file']==""){
			} else {
			?><img src="../board/upload/<?php echo $row['b_file'];?>" width="100">
			<?php
			}
			?>
		</div>
		<!--본문 끝-->

		<!--푸터 시작-->
		<div data-role="footer" data-fullscreen="true" data-position="fixed" data-theme="b">
			<div data-role="navbar">
				<ul>
					<!--
					<li><a href="#" data-icon="home">홈</a></li>
					-->
					<li><a href="#panel1" data-icon="check">로그인</a></li>
					<li><a href="#" data-icon="calendar">일정</a></li>
					<li><a href="#" data-icon="camera">사진</a></li>
					<li><a href="#panel2" data-icon="gear">설정</a></li>
				</ul>
			</div>
		</div>
		<!--푸터 끝-->
	</div>
	<!--전체 문서 끝-->
 </body>
</html>








