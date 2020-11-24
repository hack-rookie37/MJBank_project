<?php
    session_start();
    if(!isset($_SESSION['rrn'])){
        header('Location: login.php');
    }

    $name = $_SESSION['name'];
    include 'mysql.php';
    $id = $_SESSION['name'];
    $pw = $_SESSION['rrn'];
    $check = "SELECT * FROM account WHERE rrn='$pw'";
    $result = $conn -> query($check);
    $row = $result -> fetch_array(MYSQLI_ASSOC);
    ?>
    
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Transaction</title>
            <link rel="stylesheet" href="main.css?after">
        </head>
        <body>
            <header>
                <nav class="navi">
                    <ul>
                        <li>
                            <a href="#">MJ BANK</a>
                        </li>
                        <li>
                            <a href="#">About Us</a>
                        </li>
                        <li>
                            <a href="#">Site Map</a>
                        </li>

                        </ul>
                    <ul class="right">
                            <li>
                                <a href="logout.php">Logout</a>
                            </li>
                            <li>
                                <a href="account_create.php">Account Create</a>
                            </li>
                            
                            <?php

                            if(empty($row['rrn'])){
                                ?>
                                <p>아직 계좌가 없습니다.</p>
                                <p>계좌를 개설해 주세요.</p>
                            <?php
                            }else{
                                $_SESSION['a_id'] = $row['a_id'];
                                $_SESSION['a_type'] = $row['a_type'];
                                $_SESSION['balance'] = $row['balance'];
                                $_SESSION['a_date'] = $row['a_date'];
                                $_SESSION['c_status'] = $row['c_status'];
                                ?>
                                <li>
                                    <a href="history.php">Transaction History</a>
                                </li>
                                <li>
                                    <a href="deposit.php">Deposit</a>
                                </li>
                                <li>
                                    <a href="withdraw.php">Withdraw</a>
                                </li>
                                <li>
                                    <a href="transfer.php">Transfer</a>
                                </li>
                                <li>
                                    <a href="payment.php">Payment</a>
                                </li>
                            <?php
                            }
                            ?>
                    </ul>
                </nav>
            </header>
                <section>
                    <br><br><br><br><br><br>
                    <img src="MJ.PNG" class="right-img" width="500" height="500">
                    <p><?php echo $name;?>님 환영합니다!</p>
                    <p>
                        <br>
                        <pre>           
                        MJ BANK *
                        <br>
                        정훈 LEE | 동제 SHIN | 민지 CHUNG
                        business license number. 1577-0020
                        adress. 116 Myeongji-ro, southeast of Cheoin-gu, Yongin-si, Repulic Of Korea
                        </pre>

                        <pre>
                        CONTRACT *
                        <br>
                        mon-fri. 11:00-17:00 (sat/sun/holiday off)
                        </pre>
                        <pre>
                        Thank you for visiting :)
                        </pre>
                    </p>
            </section>
        </body>
        </html>
