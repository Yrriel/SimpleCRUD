<?php

    require_once 'connection.php';

    //retrieve form data
    $username = $_POST['user_name'];
    $password = $_POST['passsword'];

    session_start();

    $query = "INSERT INTO `logs`(`time`, `username`, `action`) VALUES ('$mysqlitime','$username','Logged out')";
    $conn->query($query);   

    unset($_SESSION['user_name']);
    header('location:../index.php');
    exit();



?>