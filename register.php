<title>MJ BANK</title>

<?php
include 'mysql.php';

$sql = "INSERT INTO client VALUES(
    '{$_POST['name']}',
    '{$_POST['rrn']}',
    '{$_POST['birth_date']}',
    '{$_POST['phone']}',
    '{$_POST['email']}',
    '{$_POST['job']}',
    '{$_POST['address']}'
)";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo '이미 존재하는 계정입니다.<br>';
    //echo error_log(mysqli_error(($conn)));
} else {
    echo '<script> alert("회원가입 완료"); </script>';
}

?>
<script>
    location.href = "login.php";
</script>