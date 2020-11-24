<?php
session_start();
$res = session_destroy();
if($res){
    header('Location: login.php'); // 로그아웃 성공 시 로그인 페이지로
}
?>