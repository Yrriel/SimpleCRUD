<?php

require_once 'backend/backend.Login.php';

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //retrieve form data
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    // validate login authentication
    $query = "SELECT * FROM login WHERE user_name='$username' AND password='$password'";
    $querycheckusername = "SELECT * FROM login WHERE user_name='$username'";

    $result = $conn->query($query);
    $resultusername = $conn->query($querycheckusername);

    //queries and isnert

    $mysqlitime = date('Y-m-d H:i:s');
    $mysqlid_disabledtimer = date('Y-m-d H:i:s',strtotime(' +2 minutes '));

    //check first if this user is existing
    // if($resultusername->num_rows == 0){
    //     echo '<script>
    //                 alert("User doesn'."'".'t exist. Please register a new account.");
    //                 window.location.href="index.php";
    //             </script>';
    //     exit();
    // }

    //check if this user is verified
    $query_verify = "SELECT verify_status FROM login WHERE user_name='$username'";
    $result_Arrayverify = $conn->query($query_verify);
    $result_verify = mysqli_fetch_array($result_Arrayverify);

    $verificationCheck = $result_verify['verify_status'];

    if($verificationCheck !== "TRUE"){
        echo '<script>
                    alert("This email is not verified yet. Please check your email.");
                    window.location.href="index.php";
                </script>';
        exit();
    }

    //check first if this acc is locked
    $querylogin_isthislocked = "SELECT locked_account FROM login WHERE user_name='$username'";
    $resultlogin_isthislocked = $conn->query($querylogin_isthislocked);
    $datalockinuser = mysqli_fetch_array($resultlogin_isthislocked);
    $isuserlocked = $datalockinuser['locked_account'];

    if($isuserlocked == "TRUE"){
        echo '<script>
                    alert("This account is locked. Please contact an admin for request.");
                    window.location.href="index.php";
                </script>';
        exit();
    }

    
    //check first if this acc is temporarily disabled to login
    $querylogin_isthisdisabled = "SELECT logindisabled FROM login_attempt WHERE user_name='$username'";
    $resultlogin_isthisdisabled = $conn->query($querylogin_isthisdisabled);
    $dataloginuser = mysqli_fetch_array($resultlogin_isthisdisabled);
    $isuserdisabled = $dataloginuser['logindisabled'];


    //first, compare the time in db to current time;
        // * take logintime in db
    $querylogin_disabledtime_left = "SELECT logintime FROM login_attempt WHERE user_name='$username'";
    $resultlogin_disabledtime_left = $conn->query($querylogin_disabledtime_left);
    $data_disabledtime = mysqli_fetch_array($resultlogin_disabledtime_left);
    $data_disabledtime_left = $data_disabledtime['logintime'];


    //update time for loginattempt
    $querylogin_clearloginattempts = "UPDATE login_attempt SET loginattempts='0' WHERE user_name='$username'";
    $querylogin_update_enable = "UPDATE login_attempt SET logindisabled='FALSE' WHERE user_name='$username'";

    if($isuserdisabled == "TRUE"){
        //first, compare the time in db to current time;
        // * take logintime in db

        //check if current time is before the time left
        
        if( $mysqlitime < $data_disabledtime_left){
            echo '<script>
                    alert("Too many login attempts on this user, please try again after 2 minutes");
                    window.location.href="index.php";
                </script>';
            exit();
        }
        // check if current time is after the time left
        else{
            //clear the login attempts here
            mysqli_query($conn, $querylogin_clearloginattempts);
            mysqli_query($conn, $querylogin_update_enable);
        }
    }
    // echo"<h1>Debuging : echo : {$result->num_rows}</h1>";
    if( $resultusername->num_rows == 1 && $result->num_rows == 1){
        //login success
        $dataUser = mysqli_fetch_array($result);
        $emailuser = $dataUser['email'];
        $isadmin_user = $dataUser['is_admin'];
        $nameuser = $dataUser['user_name'];
        $_SESSION['email'] = $emailuser;
        $_SESSION['user_name'] = $nameuser;
        $_SESSION['is_admin'] = $isadmin_user;
        header("Location:trytoaccess.php");
        // echo $_SESSION['user_name'];
        exit();
    }
    else{
        //login failed

            //login attempt count starts
            $querylogin_selectloginattempts = "SELECT loginattempts FROM login_attempt WHERE user_name='$username'";
            $resultlogin_selectloginattempts = $conn->query($querylogin_selectloginattempts);
            $dataloginUser = mysqli_fetch_array($resultlogin_selectloginattempts);
            $loginattempts = $dataloginUser['loginattempts'] + 1;

            $querylogin_selectsuspendedcount = "SELECT suspended_count FROM login WHERE user_name='$username'";
            $resultlogin_selectsuspendedcount = $conn->query($querylogin_selectsuspendedcount);
            $dataloginsuspend = mysqli_fetch_array($resultlogin_selectsuspendedcount);
           // $resultlogin_selectlogintime = $conn->query($querylogin_selectlogintime);

            // //check if user already has maxed 3 attempts
            $querylogin_updateloginattempts = "UPDATE login_attempt SET loginattempts='$loginattempts' WHERE user_name='$username'";
            mysqli_query($conn, $querylogin_updateloginattempts);

            //check if this will be the 3rd attempt
            if($loginattempts == 3){
                echo '<script>
                    alert("Debug Mode echo: REACHED 3 ATTEMPTS. '.$loginattempts.'. Time : '.$mysqlitime.'");
                    window.location.href="index.php";
                </script>';
                $queryloginfailed = "UPDATE login_attempt SET logindisabled='TRUE', logintime='$mysqlid_disabledtimer' WHERE user_name='$username'";
                mysqli_query($conn, $queryloginfailed);
                
                $queryloginfailed = "UPDATE login SET suspended_count='$suspended_count' WHERE user_name='$username'";
                $suspended_count = $dataloginsuspend['suspended_count'] + 1;

                if($suspended_count == 1){
                    $query_userlock = "UPDATE login SET locked_account='TRUE' WHERE user_name='$username'";
                    mysqli_query($conn, $query_userlock);
                }
            }

            else{
                echo '<script>
                    alert("Debug Mode echo: attempt #'.$loginattempts.'. Time : '.$mysqlitime.'");
                    window.location.href="index.php";
                </script>';
            }
            
            exit();
    }

    $conn->close();

}
?>