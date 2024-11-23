<?php

session_start();
if(empty($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'backend/connection.php';
$username = $_SESSION['user_name'];
$mysqlitime = date('Y-m-d H:i:s');
$query = "INSERT INTO `logs`(`time`, `username`, `action`) VALUES ('$mysqlitime','$username','Checked logs')";
$conn->query($query);
mysqli_close($conn); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/main-dashboard.css">
</head>
<body>
    <header class="main-header">
        <img src="src/svg/logobannerkanri.svg" alt="" srcset="">
        <ul>
            <li><a href="admin_homepage.php">Home</a></li>
            <li><a href="">Account</a></li>
            <li><a href="backend/backend.Logout.php">Logout</a></li>
        </ul>
    </header>
    <main class="wrapper">
        <video autoplay muted loop id="myVideo">
            <source src="src/vid/clouds.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        
        <div class="left-container">
            <ul>
                <a href="admin_homepage.php"><li>Status</li></a>
                <li style="background-color: #00000050;">Audit logs</li>
                <!-- <li>Locked Accounts</li>
                 -->
            </ul>
        </div>
        <div class="right-container">
            <div class="container1">
                <input class="request-searchUser" type="text" placeholder="Search a user">
                <button class="btn">Search</button>
            </div>
            <div class="container2">
                <div onload="table();">
                    <script>
                        function table(){
                            const xhttp = new XMLHttpRequest();
                            xhttp.onload = function(){
                                document.getElementById("table").innerHTML = this.responseText;
                            }
                            xhttp.open("GET", "backend/XMLGetLogs.php");
                            xhttp.send();
                        }
                        setInterval(function(){
                            table();
                        }, 2000)
                    </script>
                </div>
                <div id="table"></div>
            </div>  
        </div>
    </main>
    <footer class="main-footer">
        <div class="credit">
            <a href="https://github.com/yrriel" target="_blank" rel="noreferrer noopener"><img src="src/svg/justLogo.svg" ><span>Github : Yrriel</span></a>
        </div>
    </footer>
</body>
</html>