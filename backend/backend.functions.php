<?php

    function isUsernameExist($resultusername){
        if($resultusername->num_rows == 0){
            echo '<script>
                        alert("User doesn'."'".'t exist. Please register a new account.");
                        window.location.href="../index.php";
                    </script>';
            exit();
        }
        // return $resultusername->num_rows == 0 ? true : false;
    }

    function isUserVerified($verificationCheck){
        if($verificationCheck !== "TRUE"){
            echo '<script>
                        alert("This email is not verified yet. Please check your email.");
                        window.location.href="../index.php";
                    </script>';
            exit();
        }
    }

    function isUserLocked($isthisuserlocked){
        if($isthisuserlocked == "TRUE"){
            echo '<script>
                        alert("This account is locked. Please contact an admin for request.");
                        window.location.href="../index.php";
                    </script>';
            exit();
        }
    }

    function isUserDisabled($isuserdisabled, $mysqlitime, $data_disabledtime_left, $conn, $querylogin_clearloginattempts, $querylogin_update_enable){
        if($isuserdisabled == "TRUE"){
            //first, compare the time in db to current time;
            // * take logintime in db
    
            //check if current time is before the time left
            
            if( $mysqlitime < $data_disabledtime_left){
                echo '<script>
                        alert("Too many login attempts on this user, please try again after 2 minutes");
                        window.location.href="../index.php";
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
    }

    function userPassMatched($resultusername, $result){
        if($resultusername->num_rows == 1 && $result->num_rows == 1) return true;
    }

?>