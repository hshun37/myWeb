config.docType = '<!DOCTYPE html>'; // 해당 페이지의 타입
  config.font_defaultLabel = '나눔고딕'; // 기본 폰트 지정
  config.font_names = '나눔고딕/NanumGothic;돋움/Dotum'; // 폰트 목록
  config.fontSize_defaultLabel = '12px'; // 기본 폰트 크기 지정
  config.fontSize_sizes = '12/12px;14/14px;16/16px;'; // 폰트 크기
  config.language = "ko"; // 언어타입
  config.resize_enabled = true; // 에디터 크기 조절 사용여부
  config.enterMode = CKEDITOR.ENTER_BR; // 엔터시 <br> 
  config.shiftEnterMode = CKEDITOR.ENTER_P; // 쉬프트+엔터시 <p>
  config.startupFocus = true; // 글쓰기 시작시 포커스 사용여부
  config.uiColor = '#eaebe7'; // 에디터의 색상 지정
  config.toolbarCanCollapse = false; // 툴바 클릭시 접히는 여부
  config.menu_subMenuDelay = 0; // 메뉴 클릭 할 때 딜레이 값
  config.toolbarGroups  =
                              [
                              { name: 'clipboard',   groups: [ 'undo', 'clipboard' ] },
                              { name: 'editing',     groups: [ 'find', 'selection' ] },
                              { name: 'links' },
                              { name: 'insert' },
                              { name: 'tools' },
                              { name: 'document',    groups: [ 'mode' ] },
                              { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                              { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                               { name: 'styles' },
                              
                            ];
// 툴바 목록이다.| [출처]너에게제공[제목]CKEditor 한글폰트 적용 및 커스텀하는 방법[작성자]너에게제공 https://d2d2.kr/xe_tip/131267