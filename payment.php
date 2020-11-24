<html>

<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="style.css?after">
    <style>

    </style>
</head>

<body>
    <center><br><br><br>
        <div class="title">Payment</div>
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
        } else if ($row['c_status'] == 0) {
            echo "카드가 없습니다.<br><br>";
        ?>
            <button type='button' onclick="location.href = 'card_create.php'">카드발급</button>
        <?php
        } else if ($row['rrn'] == $pw) {
            //$_SESSION['a_id'] = $row['a_id'];
            //$_SESSION['a_type'] = $row['a_type'];
            //$_SESSION['balance'] = $row['balance'];
            //$_SESSION['a_date'] = $row['a_date'];
            //$_SESSION['c_status'] = $row['c_status'];
        ?>
            <form action="payment_action.php" method="POST">
                <p>*카드 번호 : &nbsp;<input type="number" name="c_id" min="0" required="required"></p>
                <p>*결제 금액 : &nbsp;<input type="number" name="amount" min="0" required="required"></p>
                <p>사용처 : &nbsp;<input type="text" name="where" min="0"></p>
                <p style="text-align:center;"><input type="submit" value="결제하기"></p>
            </form>


            <p><?php echo $id; ?>님의 카드 목록</p>
            <p>결제는 예금계좌와 연동된 카드만 가능합니다.</p>

            <table>
                <thead>
                    <tr>
                        <th>card #</th>
                        <th>account #</th>
                        <th>card type</th>
                        <th>balance</th>
                        <th>limit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT c.c_id, a.a_id, c.c_type, a.balance, c.limit_amount
                FROM account AS a
                JOIN card AS c
                ON a.rrn = c.rrn
                WHERE c.rrn = '{$_SESSION['rrn']}' and a.a_id = c.a_id
                ";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        if ($row['limit_amount'] == 0) {
                            $row['limit_amount'] = 'no limit';
                        } else if ($row['limit_amount'] == 500000) {
                            $row['limit_amount'] = '50만원';
                        } else if ($row['limit_amount'] == 5000000) {
                            $row['limit_amount'] = '500만원';
                        } else if ($row['limit_amount'] == 10000000) {
                            $row['limit_amount'] = '1000만원';
                        }
                        echo '<tr><td>' . $row['c_id'] . '</td><td>' . $row['a_id'] . '</td><td>' . $row['c_type'] . '</td><td>' . $row['balance'] . '</td><td>' . $row['limit_amount'] . '</td></tr>';
                    }
                    ?>
                </tbody>
                <button type='button' onclick="location.href = 'card_create.php'">추가 카드발급</button>
            </table>
            <br>
            
        <?php
        }
        ?>



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