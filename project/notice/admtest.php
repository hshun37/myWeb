<?php
session_start();

$_SESSION['admin_id']="admin";
$_SESSION['admin_name']="관리자";

echo $_SESSION['admin_id'];


?>