<?php

session_start();
if(empty($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_SESSION['user_name'];
    $mysqlitime = date('Y-m-d H:i:s');

    $thisUser = $_SESSION['changes-user'];
    $email = $_SESSION['changing-this'];
    $selectOptionAdmin = $_POST['optionSetAdmin'];
    $selectOptionLocked = $_POST['optionSetLocked'];

    if($selectOptionAdmin == "none" && $selectOptionLocked =="none"){
        echo '<script>
                    alert(" No changes");
                    window.location.href="../admin_homepage.php";
                </script>';
        exit();
    }

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "websitedb";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }

    if($selectOptionAdmin !== "none"){
        mysqli_query($conn, "UPDATE login SET is_admin='$selectOptionAdmin' WHERE email='$email'");
        $query = "INSERT INTO `logs`(`time`, `username`, `action`) VALUES ('$mysqlitime','$username','Changed Admin status of $thisUser to $selectOptionAdmin')";
        $conn->query($query);
    }
    if($selectOptionLocked !== "none"){
        mysqli_query($conn, "UPDATE login SET locked_account='$selectOptionLocked' WHERE email='$email'");
        $query = "INSERT INTO `logs`(`time`, `username`, `action`) VALUES ('$mysqlitime','$username','Changed Locked status of $thisUser to $selectOptionLocked')";
        $conn->query($query);
    }
    echo '<script>
    alert("Saved changes");
    window.location.href="../admin_homepage.php";
    </script>';
    exit();
}


?>