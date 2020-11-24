<?php
include 'mysql.php';
session_start();
//var_dump($_SESSION['rrn']);

if (isset($_POST['card']) && isset($_POST['limit']) && isset($_POST['a_id'])) {
    $sql = "SELECT * FROM account WHERE a_id = '{$_POST['a_id']}' and rrn = '{$_SESSION['rrn']}' and a_type = 'deposit'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if ($row == false) {
        echo '<script> alert("본인의 예금계좌번호를 입력해주세요."); history.back(); </script>';
    } else {
        $sql = "INSERT INTO card(a_id, rrn, c_date, limit_amount, c_type)
    VALUES(
        '{$_POST['a_id']}',
        '{$_SESSION['rrn']}',
        NOW(),
        '{$_POST['limit']}',
        '{$_POST['card']}'
    )";

        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            echo '카드발급 문제 발생<br>';
            echo mysqli_error(($conn));
        } else {
            $sql = "UPDATE account SET c_status = 1 WHERE a_id = {$_SESSION['a_id']}";
            mysqli_query($conn, $sql);
            echo '<script> alert("카드발급 완료"); </script>';
?>
            <script>
                location.href = "payment.php";
            </script>
<?php
        }
    }
}

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Card Issuance</title>
    <link rel="stylesheet" href="style.css?after">

</head>

<body>
    <center><br><br><br>
        <div class="title">Card Issuance</div>
        <form action="card_create.php" method="POST">
            <div style="text-align:center;">
                카드종류
                <label><input type="radio" name="card" value="credit" required="required">신용</label>
                <!--예금-->
                <label><input type="radio" name="card" value="cash" required="required">체크(현금)</label>
                <!--적금-->
            </div>
            <br>
            <div style="text-align:center;">
                1회 결제 한도
                <label><input type="radio" name="limit" value=500000 required="required">50만원</label>
                <label><input type="radio" name="limit" value=5000000 required="required"> 500만원</label>
                <label><input type="radio" name="limit" value=10000000 required="required">1000만원</label>
                <label><input type="radio" name="limit" value=0 required="required">무제한</label>
            </div>
            <br>
            연동할 계좌번호
            <p><input type="number" name="a_id" min="0" required="required"></p>
            <div class="button">
                <button type="submit">카드발급</button>
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
                $sql = "SELECT * FROM account WHERE rrn = '{$_SESSION['rrn']}' and a_type = 'deposit'";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr><td>' . $row['a_id'] . '</td><td>' . $row['a_type'] . '</td><td>' . $row['balance'] . '</td><td> ' . $row['a_date'] . '</td></tr>';
                }
                ?>
            </tbody>
        </table>


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