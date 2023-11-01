<?php
    session_start();
    include "../config_php/configuration.php";
    global $connection;
    $adminID = $_REQUEST["key_id"];
    
    $fnameErr= $usernameErr = $emailErr = $passErr = "";
    $successMsg = $conErr = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {	
        $fname= $_POST["fname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        if (empty($fname))
        {
            $fnameErr = "Full Name is required, please re-enter.";
            $_SESSION["fnameErr"] = $fnameErr;
            header("Location: edit_profile.php");
            exit();
        }
        // check if username is alphanumeric
        elseif(!preg_match('/^[a-zA-Z][0-9a-zA-Z]{2,25}$/',$username )) 
        {
            $usernameErr = "Minimum 3 alphanumeric characters, no spaces, please start with letters.";
            $_SESSION["usernameErr"] = $usernameErr;
            header("Location: edit_profile.php");
            exit();
            
        }   
        elseif (empty($email))
        {
            $emailErr = "Email is required, please re-enter.";
            $_SESSION["emailErr"] = $emailErr;
            header("Location: edit_profile.php");
            exit();
        }
        // check if e-mail address is in correct format
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {   
            $emailErr = "Invalid email format, please re-enter.";
            $_SESSION["emailErr"] = $emailErr;
            header("Location: edit_profile.php");
            exit();
            
        }
        elseif (empty( $password)) 
        {   
            $passErr = "Password is required, please re-enter.";
            $_SESSION["passErr"] = $passErr;
            header("Location: edit_profile.php");
            exit();
            
        }
        // check if password is in correct format
        elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-])\S{6,30}$/",$password))
        {   
            $passErr = "Minimum 6 characters, 1 digit, 1 uppercase letter, 1 special character and no spaces for password.";
            $_SESSION["passErr"] = $passErr;
            header("Location: edit_profile.php");
            exit();
            
        }
        else
        {
            $sqlupdate = "UPDATE admin SET fullname = '$fname', email = '$email', username = '$username', password = '$password' WHERE adminID = '$adminID'";
            if(mysqli_query($connection, $sqlupdate))
            {
                $_SESSION["adminID"] = $adminID;
                $_SESSION["admin_fullname"] = $fname;
                $_SESSION["admin_username"] = $username;
                $_SESSION["admin_email"] = $email;
                $_SESSION["admin_password"] = $password;

                $successMsg = "Your profile is successfully updated.";
                echo "<script>alert('$successMsg')</script>";
                echo "<script type=\"text/javascript\">";
                echo "window.location = \"profile.php\";";
                echo "</script>";

            }else
            {
                $conErr = "Failed to update your profile";
                echo "<script>alert('$conErr')</script>";
                echo "<script type=\"text/javascript\">";
                echo "window.location = \"profile.php\";";
                echo "</script>";
            }
        }
    }
    mysqli_close($connection);
?>
