<?php
include 'mysql.php';
session_start();

$a_id = $_POST['a_id'];
$amount = $_POST['amount'];
//echo '<script> alert('.$_SESSION['rrn'].');</script>';
//echo '<script> alert('.$amount.');</script>';
// 잘못된 계좌번호
$sql = "SELECT * FROM account WHERE a_id = $a_id and rrn = '{$_SESSION['rrn']}' and a_type = 'deposit'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
if ($row == false) {
    echo '<script> alert("잘못된 계좌번호입니다."); history.back(); </script>';
} else if ($row['balance'] < $amount) {
    echo '<script> alert("잔액이 부족합니다."); history.back(); </script>';
} else {
    $sql = "UPDATE account SET balance = balance - $amount WHERE a_id = $a_id";
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT balance FROM account WHERE a_id = $a_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $balance = $row['balance'];

    $sql = "INSERT INTO history (a_id, h_date, h_type, h_amount, memo, balance)
    VALUES(
        '{$a_id}',
        NOW(),
        'withdraw',
        '{$amount}',
        'mjbank_withdraw',
        '{$balance}'
    )";
    $result = mysqli_query($conn, $sql);

    echo mysqli_error($conn);
    echo '<script> alert("' . $a_id . ' 계좌에서 ' . $amount . '원을 출금 하였습니다."); </script>';
}

?>
<script>
    location.href = "withdraw.php";
</script>