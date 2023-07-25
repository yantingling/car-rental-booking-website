<?php   

session_start();

include "../config_php/configuration.php";
global $connection;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$fname = $email = $sentMsg = $fnameErr = $emailErr = $messageErr = "";
$to = $subject = $message = $headers = "";
$conErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $fname = $_POST["fname"];
    $sentMsg = $_POST["message"];

    
    if (empty($fname)) {
        $fnameErr = "Full name is required, please re-enter.";
        $_SESSION["fnameErr"] = $fnameErr;
        header("Location: contact_us.php");
        exit();
    }
    elseif (empty($email)) {
        $emailErr = "Email is required, please re-enter.";
        $_SESSION["emailErr"] = $emailErr;
        header("Location: contact_us.php");
        exit();
    }
    elseif (empty($sentMsg)) {
        $messageErr = "Message is required, please re-enter.";
        $_SESSION["messageErr"] = $messageErr;
        header("Location: contact_us.php");
        exit();
    }
    // check if e-mail address is in correct format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format, please re-enter.";
        $_SESSION["emailErr"] = $emailErr;
        header("Location: contact_us.php");
        exit();
    }else {

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'carme.geeklords@gmail.com';
        $mail->Password = 'vcjrgmloopdhpuhj';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('carme.geeklords@gmail.com');
        $mail->addAddress('carme.geeklords@gmail.com');

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Customer Enquiry';
        $mail->Body =  "Sender's Full Name: " . $fname;
        $mail->Body .= "<br>Sender's E-mail: " . $email;
        $mail->Body .= "<br>Sender's Message:<br>" . $sentMsg;

        if($mail->send())
        {
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
            $mail->Subject = 'Customer Enquiry Received';
            $mail->Body =  "Dear " .$fname. ",";
            $mail->Body .= "<br><br>We have received your enquiry. It will be solved within 2-3 working days.<br><br>";
            $mail->Body .= "The following is your enquiry:<br>" . $sentMsg;
            $mail->Body .= "<br><br>Warmest Regards, <br><i>CarMe Admin</i>";

            if($mail->send())
            {
                $successMsg = "Enquiry is successfully sent!";
                echo "<script>alert('$successMsg'); location.href = '../index.php';</script>";
            }
            else
            {
                $failed = "Enquiry is failed to be sent!";
                echo "<script>alert('$failed'); location.href = '../index.php';</script>";
            }
        }
        else
        {
            $failed = "Enquiry is failed to be sent!";
            echo "<script>alert('$failed'); location.href = '../index.php';</script>";
        }

        $mail->smtpClose();
    }
}

?>