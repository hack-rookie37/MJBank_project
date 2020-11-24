<html>

<head>
    <meta charset="UTF-8">
    <title>History</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <center><br><br><br>
        <div class="title">HISTORY</div>
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
            <!--계좌 정보 (계좌번호, 이름, 개설일...)
        거래내역 기간 설정(옵션)
    -->
            <form action="history.php" method="POST">
                <p>*계좌번호 : &nbsp;<input type="number" name="a_id" min="0" required="required"></p>
                <p style="text-align:center;"><input type="submit" value="내역확인"></p>
                <button type="button" onclick="location.href = 'history.php'">모두보기</button>
            </form>

            <?php

            if (isset($_POST['a_id'])) {
                $sql = "SELECT a.a_id, a.a_type, h.h_date, h.h_type, h.h_amount, h.memo, h.balance, h.h_number
                    FROM account AS a
                    JOIN history AS h
                    ON a.a_id = h.a_id
                    WHERE a.rrn = '{$_SESSION['rrn']}' and a.a_id = '{$_POST['a_id']}'
                    ORDER BY h.h_number DESC";
                $result = mysqli_query($conn, $sql);
                $branch = mysqli_fetch_array($result);
            } else {
                $sql = "SELECT a.a_id, a.a_type, h.h_date, h.h_type, h.h_amount, h.memo, h.balance, h.h_number
                    FROM account AS a
                    JOIN history AS h
                    ON a.a_id = h.a_id
                    WHERE a.rrn = '{$_SESSION['rrn']}'
                    ORDER BY h.h_number DESC";
                $result = mysqli_query($conn, $sql);
                $branch = mysqli_fetch_array($result);
            }
           
            if ($branch == null) {
            ?>
                거래 내역이 없습니다. <br><br>
                <button type="button" onclick="location.href = 'transaction.php'">돌아가기</button>
            <?php
            } else {
            ?>
                <p><?php echo $id; ?>님의 거래내역</p>
                <table>
                    <thead>
                        <tr>
                            <th>account #</th>
                            <th>account type</th>
                            <th>transaction date</th>
                            <th>transaction type</th>
                            <th>amount</th>
                            <th>memo</th>
                            <th>balance</th>
                            <th>transaction #</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<tr><td>' . $row['a_id'] . '</td><td>' . $row['a_type'] . '</td><td>' . $row['h_date']
                        . '</td><td> ' . $row['h_type'] . '</td><td>' . $row['h_amount'] . '</td><td>' . $row['memo']
                        . '</td><td>' . $row['balance'] . '</td><td>' . $row['h_number']
                        . '</td></tr>';
                }
            }
        }
                ?> <footer>
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