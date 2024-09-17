<?php

    function isUsernameExist($resultusername){
        // if($resultusername->num_rows == 0){
        //     echo '<script>
        //                 alert("User doesn'."'".'t exist. Please register a new account.");
        //                 window.location.href="index.php";
        //             </script>';
        //     exit();
        // }
        return $resultusername->num_rows == 0 ? true : false;
    }

    function isUserVerified($verificationCheck){
        // echo '<script>
        //             alert("This email is not verified yet. Please check your email.");
        //             window.location.href="index.php";
        //         </script>';
        // exit();
        return $verificationCheck == "TRUE" ? true : false;
    }

    function isUserLocked($isuserlocked){
        // if($isuserlocked == "TRUE"){
        //     echo '<script>
        //                 alert("This account is locked. Please contact an admin for request.");
        //                 window.location.href="index.php";
        //             </script>';
        //     exit();
        // }
        return $isuserlocked == "TRUE" ? true : false;
    }

?>