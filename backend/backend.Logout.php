<?php


    //retrieve form data
    $username = $_POST['user_name'];
    $password = $_POST['passsword'];

    session_start();
    unset($_SESSION['user_name']);
    header('location:../index.php');
    exit();



?>