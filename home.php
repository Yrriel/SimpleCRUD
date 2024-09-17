
<?php

session_start();
if(empty($_SESSION['user_name'])){
    header('location:index.php');
    die();
}
$username = $_SESSION['user_name'];
$is_admin = $_SESSION['is_admin'];
$email = $_SESSION['email'];

if($is_admin == "TRUE"){
    echo '<script>windows.location.href="admin_homepage.php"</script>';
    header("Location:admin_homepage.php");
}


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
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </header>
    <main class="wrapper">
        <video autoplay muted loop id="myVideo">
            <source src="src/vid/clouds.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        
        <div class="right-container">
        <h1>hello <?php echo $username; ?>, you gained access!</h1>
        <p>This is the normal UI for normal access. To see admin UI, please login with an account that has admin access</p>
        <p>Admin status: <?php echo $is_admin?></p>
        <p>Email: <?php echo $email ?></p> 

        <h2>
            Admin account:
        </h2>
        <h3>Username : HappyDuck</h3>
        <h3>Password : 123123</h3>

        <a href="backend/backend.Logout.php" style="color: #fff; ">logout</a><br> <br>
        </div>

    </main>
    <footer class="main-footer">
        <div class="credit">
            <a href="https://github.com/yrriel" target="_blank" rel="noreferrer noopener"><img src="src/svg/justLogo.svg" ><span>Github : Yrriel</span></a>
        </div>
    </footer>
        
        
        
</body>
</html>