<?php

require_once 'backend.functions.php';

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //initialize connections to database
    require_once 'connection.php';

    //retrieve form data
    $username = ($_POST['username']);
    $password = ($_POST['password']);

    // validate login authentication
    $query = "SELECT * FROM login WHERE user_name='$username' AND password='$password'";
    $querycheckusername = "SELECT * FROM login WHERE user_name='$username'";

    $result = $conn->query($query);
    $resultByUsername = $conn->query($querycheckusername);

    //queries and isnert

    $mysqlitime = date('Y-m-d H:i:s');
    $mysqlid_disabledtimer = date('Y-m-d H:i:s',strtotime(' +2 minutes '));

    isUsernameExist($resultByUsername); //is user exist?

    //fetching all data from the user
    $querylogin_selectAllFromUser = "SELECT * FROM login_attempt WHERE user_name='$username'";
    $resultlogin_selectAllFromUser = $conn->query($querylogin_selectAllFromUser);
    $resultlogin_fetchedArrayFrom_login = mysqli_fetch_array($resultByUsername);              //  FROM TABLE login
    $resultlogin_fetchedArrayFrom_loginAttempt = mysqli_fetch_array($resultlogin_selectAllFromUser); //  FROM TABLE login_attempt

    //---------------queries--------------
    //update time for loginattempt
    $querylogin_clearloginattempts = "UPDATE login_attempt SET loginattempts='0' WHERE user_name='$username'";
    $querylogin_update_enable = "UPDATE login_attempt SET logindisabled='FALSE' WHERE user_name='$username'";

    //-------------end of queries-----------

    //FROM TABLE `login`
    $verificationCheck = $resultlogin_fetchedArrayFrom_login['verify_status'];
    $isuserlocked = $resultlogin_fetchedArrayFrom_login['locked_account'];

    //FROM TABLE `login_attempt`
    $isuserdisabled = $resultlogin_fetchedArrayFrom_loginAttempt['logindisabled'];
    $data_disabledtime_left = $resultlogin_fetchedArrayFrom_loginAttempt['logintime'];

    isUserVerified($verificationCheck);   //is user verified?
    isUserLocked($isuserlocked);        //is user locked?

    isUserDisabled($isuserdisabled, $mysqlitime, $data_disabledtime_left, $conn, $querylogin_clearloginattempts, $querylogin_update_enable);
    if(userPassMatched($resultByUsername, $result)){
        //login success

        $query = "INSERT INTO `logs`(`time`, `username`, `action`) VALUES ('$mysqlitime','$username','Logged in')";
        $conn->query($query);

        $dataUser = mysqli_fetch_array($result);
        $_SESSION['email'] = $dataUser['email'];
        $_SESSION['user_name'] = $dataUser['user_name'];
        $_SESSION['is_admin'] = $dataUser['is_admin'];
        header("Location:../home.php");
        exit();
    }
    else{
        //login failed

            //login attempt count starts
            $loginattempts = $resultlogin_fetchedArrayFrom_loginAttempt['loginattempts'] + 1;


            // //check if user already has maxed 3 attempts
            $querylogin_updateloginattempts = "UPDATE login_attempt SET loginattempts='$loginattempts' WHERE user_name='$username'";
            mysqli_query($conn, $querylogin_updateloginattempts);

            //check if this will be the 3rd attempt
            if($loginattempts == 3){
                echo '<script>
                    alert("Debug Mode echo: REACHED 3 ATTEMPTS. '.$loginattempts.'. Time : '.$mysqlitime.'");
                    window.location.href="../index.php";
                </script>';
                $queryloginfailed = "UPDATE login_attempt SET logindisabled='TRUE', logintime='$mysqlid_disabledtimer' WHERE user_name='$username'";
                mysqli_query($conn, $queryloginfailed);
                
                $suspended_count = $resultlogin_fetchedArrayFrom_login['suspended_count'] + 1;
                $queryloginfailed = "UPDATE login SET suspended_count='$suspended_count' WHERE user_name='$username'";

                if($suspended_count == 1){
                    $query_userlock = "UPDATE login SET locked_account='TRUE' WHERE user_name='$username'";
                    mysqli_query($conn, $query_userlock);
                }
                else{
                    mysqli_query($conn, $queryloginfailed);
                }
            }

            else{
                echo '<script>
                    alert("Debug Mode echo: attempt #'.$loginattempts.'. Time : '.$mysqlitime.'");
                    window.location.href="../index.php";
                </script>';
            }
            
            exit();
    }

    $conn->close();

}
?>