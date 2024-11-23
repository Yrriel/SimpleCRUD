<?php

session_start();
if(empty($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

//Database Connection
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "websitedb";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if($conn -> connect_error){
    die("Connection failed: ". $conn->connect_error);
}

$email = $_GET["email"];
$token = $_GET["token"];

$query = "SELECT * FROM login WHERE email='$email'";
$result = $conn->query($query);
$resultarrayuser = mysqli_fetch_array($result);

$displayUsername = $resultarrayuser['user_name'];
$displayEmail = $resultarrayuser['email'];
$displayAdmin = $resultarrayuser['is_admin'];
$displayLocked = $resultarrayuser['locked_account'];

$_SESSION['changing-this'] = $displayEmail;
$_SESSION['changes-user'] = $displayUsername;

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
                <li>Status</li>
                <!-- <li>Locked Accounts</li>
                <li>Audit logs</li> -->
            </ul>
        </div>
        <div class="right-container">
            <div class="container1 profile-header">
                <span class="edit-profile-header"><img src="profile-user.png" alt="" srcset="">Edit Access</span>
            </div>
            <div class="container2" style="background: rgba(0,0,0,.8); border-radius:0px" id="profile-details">
                <form action="backend/backend.edituser.php" method="post">
                    <h1><?php echo $displayUsername?></h1>
                    <p>E-mail: <?php echo $displayEmail?></p>
                    <span>
                    <p>Admin status : <?php echo $displayAdmin?>
                    <select name="optionSetAdmin" id="">
                            <option value="none">Set Admin Status</option>
                            <option value="TRUE">TRUE</option>
                            <option value="FALSE">FALSE</option>
                        </select>
                    </p>
                        
                    </span>
                    <p>Locked status : <?php echo $displayLocked?>
                    <select name="optionSetLocked" id="">
                            <option value="none">Set Locked Status</option>
                            <option value="TRUE">TRUE</option>
                            <option value="FALSE">FALSE</option>
                        </select>
                    </p>
                        
                    </span>

                    <span><button type="submit">Save</button></span>
                </form>
                
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