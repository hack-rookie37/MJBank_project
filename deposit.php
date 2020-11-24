<html>

<head>
    <meta charset="UTF-8">
    <title>Deposit</title>
    <link rel="stylesheet" href="style.css?after">
</head>

<body>
    <center><br><br><br>
        <div class="title">DEPOSIT</div>
        <?php
        include 'mysql.php';
        session_start();

        $id = $_SESSION['name'];
        $pw = $_SESSION['rrn'];
        //var_dump($_SESSION['name']);
        //var_dump($_SESSION['rrn']);
        //var_dump($_SESSION['a_id']);
        $check = "SELECT * FROM account WHERE rrn='$pw'";
        $result = $conn->query($check);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (empty($row['rrn'])) {
            echo "계좌가 없습니다.<br><br>";
        ?>
            <button type='button' onclick="location.href = 'account_create.php'">계좌개설</button>
        <?php
        } else if ($row['rrn'] == $pw) {
            //$_SESSION['a_id'] = $row['a_id'];
            //$_SESSION['a_type'] = $row['a_type'];
            //$_SESSION['balance'] = $row['balance'];
            //$_SESSION['a_date'] = $row['a_date'];
            //$_SESSION['c_status'] = $row['c_status'];
        ?>
            <form action="deposit_action.php" method="POST">
                <p>*입금 계좌 : &nbsp;<input type="number" name="a_id" min="0" required="required"></p>
                <p>*입금 금액 : &nbsp;<input type="number" name="amount" min="0" required="required"></p>
                <p style="text-align:center;"><input type="submit" value="입금하기"></p>
            </form>

            <p><?php echo $id; ?>님의 계좌 목록</p>

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
            }
                ?>
                </tbody>
            </table>

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
</body>

</html>