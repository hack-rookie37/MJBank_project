<?php
include 'mysql.php';
session_start();

if (isset($_POST['account'])) {
    $sql = "INSERT INTO account(name, rrn, a_type, balance, a_date, c_status, phone, email)
    VALUES(
        '{$_SESSION['name']}',
        '{$_SESSION['rrn']}',
        '{$_POST['account']}',
        '0',
        NOW(),
        '0',
        '{$_SESSION['phone']}',
        '{$_SESSION['email']}'
    )";
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        echo '계좌개설 문제 발생<br>';
        echo mysqli_error(($conn));
    } else {
        $sql = "SELECT a_id FROM account WHERE rrn = '{$_SESSION['rrn']}'";
        $result = mysqli_query($conn, $sql);
        $recent = 0;
        while($row = mysqli_fetch_array($result)){
            if($recent < $row['a_id']){
                $recent = $row['a_id'];
            }
        }
        $row = mysqli_fetch_array($result);
        $sql = "INSERT INTO history (a_id, h_date, h_type, h_amount, memo, balance)
        VALUES(
            '{$recent}',
            NOW(),
            'ISSUE',
            '0',
            'ISSUE',
            '0'
        )";
        mysqli_query($conn, $sql);
        echo '<script> alert("계좌개설 완료"); </script>';
        //header('Location: transaction.php');
?>
        <script>
            location.href = "transaction.php";
        </script>
<?php
    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Account_create</title>
    <link rel="stylesheet" href="style.css?after">

</head>

<body>
    <center><br><br><br>
        <div class="title">Acount Create</div>
        <form action="account_create.php" method="POST">
            <div style="text-align:center;">
                계좌종류
                <label><input type="radio" name="account" value="deposit">예금</label>
                <!--예금-->
                <label><input type="radio" name="account" value="savings">적금</label>
                <!--적금-->
            </div>
            <br>
            <div class="button">
                <button type="submit">계좌개설</button>
            </div>

        </form>

        <p><?php echo $_SESSION['name']; ?>님의 계좌 목록</p>

        <table>
            <thead>
                <tr>
                    <th>account #</th>
                    <th>account type</th>
                    <th>balance</th>
                    <th>issue date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM account WHERE rrn = '{$_SESSION['rrn']}'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr><td>' . $row['a_id'] . '</td><td>' . $row['a_type'] . '</td><td>' . $row['balance'] . '</td><td> ' . $row['a_date'] . '</td></tr>';
                }
                ?>
            </tbody>
</body>
<footer>
    <div>
        <button type="button" onclick="location.href = 'transaction.php'">메인으로</button>
        <button type="button" onclick="location.href = 'logout.php'">로그아웃</button>
    </div>
    <div>
        <a href="#">About us</a>
        <a href="#">Terms of Service</a>
        <a href="#">Site map</a>
    </div>
    <div>
        2020 Copyright MJBANK
    </div>

</footer>

</html>