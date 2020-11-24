<?php
include 'mysql.php'; // mysql 접속
session_start();

//login.php에서 받아온 POST값 변수에 저장
$id = $_POST['name']; 
$pw = $_POST['rrn'];

/*
 root 계정 접속
if($id=='root' || $pw=='root'){
    header('Location: root.html'); 
}
*/
if($id==''||$pw==''){
    echo '<script> alert("ID 또는 PW를 입력해주세요."); history.back(); </script>';
}else{
    //rrn 일치하는 client찾아서 select
    $check = "SELECT * FROM client WHERE name = '$id' and rrn='$pw'";
    $result = $conn -> query($check);
    $row = $result -> fetch_array(MYSQLI_ASSOC);
    //rrn 일차하면 session 변수들에 값 불러와서 저장
    if($row['rrn']==$pw){
        $_SESSION['name']=$row['name'];
        $_SESSION['rrn']=$row['rrn'];
        $_SESSION['birth_date']=$row['birth_date'];
        $_SESSION['phone']=$row['phone'];
        $_SESSION['email']=$row['email'];
        $_SESSION['job']=$row['job'];
        $_SESSION['address']=$row['address'];
        if(isset($_SESSION['rrn'])){
            header('Location: transaction.php'); // 로그인 성공 시 이동할 페이지
        }else{
            echo "알 수 없는 오류 발생";
        }
    }else{
        echo '<script> alert("ID 또는 PW가 올바르지 않습니다."); history.back(); </script>';
    }
}
