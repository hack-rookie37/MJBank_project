<?php
include 'mysql.php';
session_start();

$sa_id = $_POST['sa_id'];
$ra_id = $_POST['ra_id'];
$amount = $_POST['amount'];
//echo '<script> alert('.$_SESSION['rrn'].');</script>';
//echo '<script> alert('.$amount.');</script>';
// 잘못된 계좌번호

$sender = "SELECT * FROM account WHERE a_id = $sa_id and rrn = '{$_SESSION['rrn']}' and a_type = 'deposit'";
$receiver = "SELECT * FROM account WHERE a_id = $ra_id";
$sresult = mysqli_query($conn, $sender);
$rresult = mysqli_query($conn, $receiver);
$srow = mysqli_fetch_array($sresult);
$rrow = mysqli_fetch_array($rresult);
if ($srow == false || $rrow == false) {
    echo '<script> alert("입금 또는 출금 계좌번호가 올바르지 않습니다."); history.back(); </script>';
} else if ($srow['balance'] < $amount) {
    echo '<script> alert("출금계좌의 잔액이 부족합니다."); history.back(); </script>';
} else {
    $send = "UPDATE account SET balance = balance - $amount WHERE a_id = $sa_id";
    $result = mysqli_query($conn, $send);
    if ($result == false) {
        echo '<script> alert("알 수 없는 오류 발생. 거래 취소"); history.back(); </script>';
    }
    $receive = "UPDATE account SET balance = balance + $amount WHERE a_id = $ra_id";
    $result = mysqli_query($conn, $receive);
    if ($result == false) {
        echo '<script> alert("알 수 없는 오류 발생. 거래 취소"); history.back(); </script>';
    }

    $sql = "SELECT balance FROM account WHERE a_id = $sa_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $balance = $row['balance'];

    $sql = "INSERT INTO history (a_id, h_date, h_type, h_amount, memo, balance)
        VALUES(
            '{$sa_id}',
            NOW(),
            'withdraw',
            '{$amount}',
            'transfer to {$ra_id}',
            '{$balance}'
        )";
    $result = mysqli_query($conn, $sql);


    $sql = "SELECT balance FROM account WHERE a_id = $ra_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $balance = $row['balance'];

    $sql = "INSERT INTO history (a_id, h_date, h_type, h_amount, memo, balance)
        VALUES(
            '{$ra_id}',
            NOW(),
            'deposit',
            '{$amount}',
            'transfer from {$sa_id}',
            '{$balance}'
        )";
    $result = mysqli_query($conn, $sql);


    echo '<script> alert("' . $sa_id . '계좌에서 ' . $ra_id . '계좌에 ' . $amount . '원을 이체 하였습니다."); </script>';
}
?>
<script>
    location.href = "transfer.php";
</script>