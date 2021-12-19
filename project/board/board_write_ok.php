<meta charset="utf-8">
<?php
session_start();
include "../config/dbconnect.php";

$gallery_title = $_POST['board_title'];
$gallery_name = $_POST['board_name'];
$gallery_email = $_POST['board_email'];
$gallery_content = $_POST['board_content'];
$gallery_pass = $_POST['board_pass'];

$gallery_wdate = date("Y-m-d H:i:s");
$gallery_hit = 0;
$gallery_like = 0;

//파일업로드 시작
$files = $_FILES['upfile'];
    $count = count($files["name"]);
    
    
    $upload_dir = 'board_upload/'; #파일을 보관하는 공간

    for ($i=0; $i<$count; $i++)
    {
        $upfile_name[$i] = $files["name"][$i]; //파일의 이름
        $upfile_tmp_name[$i] = $files["tmp_name"][$i]; //임시저장 이름
        $upfile_type[$i] = $files["type"][$i]; //파일의 형식
        $upfile_size[$i] = $files["size"][$i]; //파일의 크기
        $upfile_error[$i] = $files["error"][$i]; //파일의 에러정보

        $file = explode(".",$upfile_name[$i]);
        $file_name = $file[0]; //.을 기준으로 파일명

        echo $file_name;
        $file_ext = $file[1]; //.을 기준으로 확장자명
        echo $file_ext;

        if(!$upfile_error[$i]) {
            $new_file_name = date("Y_m_d_H_i_s"); //날짜시간으로 이름지정
            $new_file_name = $new_file_name."_".$i; //날짜시간이름_해당번호로 이름지정
            $copied_file_name[$i] = $new_file_name.".".$file_ext; //날짜시간이름.확장자
            $uploaded_file[$i] = $upload_dir.$copied_file_name[$i]; //업로드 파일명

            if ($upfile_size[$i] > 51200000){
                echo("<script>
                alert('업로드 파일 크기가 지정된 용량(5MB)을 초과합니다. 파일크기를 체크해주세요');
                history.back();
                </script>
                ");
                exit;
            }
            
            if(
            ($upfile_type[$i] != "image/gif")&&($upfile_type[$i] != "image/jpeg")&&($upfile_type[$i] != "image/png")&&($upfile_type[$i] != "image/jpg")
            ){
                echo("<script>
                alert('이미지 파일만 업로드 가능합니다.');
                history.back();
                </script>
                ");
                exit;
            }
            
            if(!move_uploaded_file($upfile_tmp_name[$i],$uploaded_file[$i])) {
                echo("<script>
                alert('파일을 지정한 디렉토리에 복사하는데 실패하였습니다.');
                history.back();
                </script>
                ");
                exit;
            }
        }

    }
//파일업로드 끝

/*
$sql = "insert into gallery(gallery_title,gallery_name,gallery_email,gallery_content,
gallery_pass,gallery_id,gallery_wdate,gallery_hit,gallery_like) 
values ('".$gallery_title."','".$gallery_name."','".$gallery_email."',
'".$gallery_content."','".$gallery_pass."','".$gallery_id."',
'".$gallery_wdate."','".$gallery_hit."','".$gallery_like."')";
*/

//mysql문의 확장판
// $sql = "insert into gallery set ";
// $sql.= "gallery_title = '".$gallery_title."',";
// $sql.= "gallery_name = '".$gallery_name."',";
// $sql.= "gallery_email = '".$gallery_email."',";
// $sql.= "gallery_content = '".$gallery_content."',";
// $sql.= "gallery_pass = '".$gallery_pass."',";
// //$sql.= "gallery_id = '".$gallery_id."',";
// $sql.= "gallery_wdate = '".$gallery_wdate."',";
// $sql.= "gallery_hit = '".$gallery_hit."',";
// $sql.= "gallery_like = '".$gallery_like."',";
// $sql.= "file_name_0 = '".$upfile_name[0]."',";
// $sql.= "file_name_1 = '".$upfile_name[1]."',";
// $sql.= "file_name_2 = '".$upfile_name[2]."',";
// $sql.= "file_copied_0 = '".$copied_file_name[0]."',";
// $sql.= "file_copied_1 = '".$copied_file_name[1]."',";
// $sql.= "file_copied_2 = '".$copied_file_name[2]."' ";

$sql = "insert into board set board_title = '".$gallery_title."'
        ,board_name = '".$gallery_name."', board_email = '".$gallery_email."'
        ,board_content = '".$gallery_content."', board_pass = '".$gallery_pass."'
        , board_wdate = '".$gallery_wdate."', file_name_0 = '".$upfile_name[0]."'
        ,file_copied_0 = '".$copied_file_name[0]."'";

$result = mysqli_query($con, $sql);

?>
<script>
    
   alert("일기장 등록이 완료되었습니다.");
   location.href="board_list.php";
    
</script>



