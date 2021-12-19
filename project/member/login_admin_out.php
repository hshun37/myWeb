<?php
session_start();

//$_SESSION[] 쓸때 db연결 필요없음
if($_SESSION['admin_id']!=null){
    session_destroy();
}
echo "<script>location.href='/';</script>;"

?>





