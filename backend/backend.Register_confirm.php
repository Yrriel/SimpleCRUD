<?php

if (!isset($_GET["email"]) || !$_GET["token"]) {
    // exists and equal to link1
    header('Location: ../index.php');
    exit();
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



$query_userdb_email = "SELECT email FROM login WHERE email='$email'";
$result_emailuserdb = $conn->query($query_userdb_email);
$result_useremaildb = mysqli_fetch_array($result_emailuserdb);

$query_userdb_token = "SELECT token FROM login WHERE email='$email'";
$result_tokenuserdb = $conn->query($query_userdb_token);
$result_usertokendb = mysqli_fetch_array($result_tokenuserdb);

$email_db = $result_useremaildb['email'];
$token_db = $result_usertokendb['token'];


if($email == $email_db && $token == $token_db){

    //set verify to TRUE
    $query_updateUserVerify = "UPDATE login SET verify_status='TRUE' WHERE email='$email'";
    mysqli_query($conn, $query_updateUserVerify);

    echo '<script>
                    alert("Successfully verified. you may now login to your account");
                    window.location.href="../index.php";
                </script>';
        exit();

    
}
else{
    echo '<script>
                    alert("Debug : email or Token does not match from the database. returning to login.");
                    window.location.href="../index.php";
                </script>';
        exit();
}
//set verify to TRUE
$query_updateUserVerify = "UPDATE login SET verify_status='TRUE' WHERE email='$email'";
mysqli_query($conn, $query_updateUserVerify);

echo '<script>
                    alert("Successfully verified. you may now login to your account");
                    window.location.href="../index.php";
                </script>';
        exit();
?>