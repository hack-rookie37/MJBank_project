<html>
<head>
    <title>MJ Bank login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>

<?php
    session_start();
    if(!isset($_SESSION['rrn'])){
        
    
    ?>    
    <body>
        
        <center><br><br><br>
            <h1>MJ Bank Login</h1>
            <br><br><br>
            <form action="login_check.php" method="POST">
                <div style="text-align:center;"></div>
                    <label for="name">&nbsp;ID&nbsp; </label>
                    <input type="text" name="name" placeholder="이름">
                </div>
                <div style="text-align:center;">
                    <label for="rrn">PW </label>
                    <input type="password" name="rrn" placeholder="주민번호">
                </div>
                <br>
                <div class="button">
                    <button type="submit">로그인</button>
                </div>
        
            </form>
    <?php
    }else{
    ?>
    <p>이미 로그인 중입니다.</p>
    <p><button type="button" onclick="location.href = 'transaction.php'">업무보기</button></p>
    <p><button type="button" onclick="location.href = 'logout.php'">로그아웃</button></p>
    <?php
    }
    ?>
<br><br>
    <button onclick="location.href='index.html'">회원가입</button>
</center>
<footer>
    <div>
    <p><a href="#">About us</a>
        <a href="#">Terms of Service</a>
        <a href="#">Site map</a></p>
    </div>
    <div>
        <p>2020 Copyright MJBANK</p>
    </div>

</footer>

</body>
</html>



        
        