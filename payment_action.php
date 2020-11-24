<?php
include 'mysql.php';
session_start();

$c_id = $_POST['c_id'];
$amount = $_POST['amount'];
$memo = $_POST['where'];
//echo '<script> alert('.$_SESSION['rrn'].');</script>';
//echo '<script> alert('.$amount.');</script>';
$sql = "SELECT * FROM card WHERE c_id = $c_id and rrn = '{$_SESSION['rrn']}'";
$result = mysqli_query($conn, $sql);
$crow = mysqli_fetch_array($result);
if($crow == false){
    echo '<script> alert("잘못된 카드번호입니다."); history.back(); </script>';
}else if($crow['limit_amount'] < $amount){
    echo '<script> alert("1회 결제 한도 초과"); history.back();</script>';
}else{
    $sql = "SELECT * FROM account WHERE a_id = '{$crow['a_id']}'";
    $result = mysqli_query($conn, $sql);
    $arow = mysqli_fetch_array($result);

    if($crow['c_type'] == 'cash' && $arow['balance'] < $amount){
        echo '<script> alert("계좌잔액이 부족합니다."); history.back(); </script>';    
    }else{
        $sql = "UPDATE account SET balance = balance - $amount WHERE a_id = '{$crow['a_id']}'";
        $result = mysqli_query($conn, $sql);
        $sql = "INSERT INTO history (a_id, h_date, h_type, h_amount, memo, balance)
        VALUES(
            '{$crow['a_id']}',
            NOW(),
            'withdraw',
            '{$amount}',
            '{$memo}',
            '{$arow['balance']}'
        )";
        mysqli_query($conn, $sql);
        echo '<script> alert("결제완료."); </script>';    
    }
}
?>
<script>
    location.href = "payment.php";
</script>