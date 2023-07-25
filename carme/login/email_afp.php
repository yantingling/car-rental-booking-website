<?php
    session_start();
    // Include config file
    include "../config_php/configuration.php";
    global $connection;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $username = $password = $email = "";
    $bothErr = $usernameErr = $emailErr = "";

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $username = $_POST["fp-username"];
        $email = $_POST["fp-email"];

        //check if username and email are empty
        if(empty($username) && empty($email))
        {
            $bothErr = "Please enter a username and email.";
            $_SESSION["bothErr"] = $bothErr;
            header("Location: admin_forgot_password.php");
            exit();
        }
        // Check if username is empty
        elseif(empty($username))
        {
            $usernameErr = "Please enter a username.";
            $_SESSION["usernameErr"] = $usernameErr;
            header("Location: admin_forgot_password.php");
            exit();
        }
        // Check if email is empty
        elseif(empty($email))
        {
            $emailErr = "Please enter a email.";
            $_SESSION["emailErr"] = $emailErr;
            header("Location: admin_forgot_password.php");
            exit();
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {   
            $emailErr = "Invalid email format, please re-enter.";
            $_SESSION["emailErr"] = $emailErr;
            header("Location: admin_forgot_password.php");
            exit();
        }
        else
        {
        // Verify credentials
        
            $sql=mysqli_query($connection,"SELECT * FROM admin WHERE username='$username' and email='$email' ");
            $row  = mysqli_fetch_array($sql);
            if(is_array($row))
            {
                if($row['username']== $username && $row['email']== $email)
                {
                    $_SESSION["password"]=$row['password'];
                    
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'carme.geeklords@gmail.com';
                    $mail->Password = 'vcjrgmloopdhpuhj';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('carme.geeklords@gmail.com');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = 'Password to Login CarMe';
                    $mail->Body =  "Dear " .$username. ",";
                    $mail->Body .= "<br><br>Your password for CarMe admin account is as followed:<br><br><b>" .$_SESSION['password']. "</b>";
                    $mail->Body .= "<br><br>Thank you!<br><br>Warmest Regards,<br><i>CarMe</i>";

                    if($mail->send())
                    {
                        $successMsg = "Password has been sent to your email. Please check it.";
                        echo "<script>alert('$successMsg'); location.href = 'admin_forgot_password.php';</script>";
                    }
                    else
                    {
                        $failed = "Password is failed to sent. Please try again.";
                        echo "<script>alert('$failed'); location.href = 'admin_forgot_password.php';</script>";
                    }

                    $mail->smtpClose();  
                    unset($_SESSION["password"]);
                }
            }
            else
            {
                $bothErr = "Invalid Username or Email.";
                $_SESSION["bothErr"] = $bothErr;
                header("Location: admin_forgot_password.php");
                exit();
            }
        }
    }
?>