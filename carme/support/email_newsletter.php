<?php   
include "../config_php/configuration.php";
global $connection;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$customer_email = $emailErr = "";
$to = $subject = $message = $headers = "";
$conErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $customer_email = $_POST["nwsl-email"];

    if (empty($customer_email)) {
        $emailErr = "Failed subscription to CarMe newsletter! Email is required, please re-enter!";
        echo "<script>alert('$emailErr')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    // check if e-mail address is in correct format
    elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Failed subscription to CarMe newsletter! Invalid email format, please re-enter!";
        echo "<script>alert('$emailErr')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    else{

        $sql_nl="SELECT * FROM newsletter WHERE email='$customer_email'";
        $result= mysqli_query($connection, $sql_nl);
        if(mysqli_num_rows($result)>0)
        {
            $emailErr = "You have previously subscribed to CarMe newsletter!";
            echo "<script>alert('$emailErr')</script>";
            echo "<script type=\"text/javascript\">";
            echo "window.location = \"../index.php\";";
            echo "</script>";
        }
        else
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
            $mail->addAddress($customer_email);

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Successful Subscribption to CarMe Newsletter';
            $mail->Body =  "Dear User,<br><br>We are pleased to tell you that you have successfully subscribed to CarMe Newsletter.<br><br>Thank you!<br><br>Warmest Regards,<br><i>CarMe Admin</i>";

            if($mail->send())
            {
                $sql ="INSERT INTO newsletter (email) VALUES('$customer_email')";
                mysqli_query($connection, $sql);

                $successMsg = "Successful subscription to CarMe newsletter!";
                echo "<script>alert('$successMsg'); location.href = '../index.php';</script>";
            }
            else
            {
                $failed = "Failed subscription to CarMe newsletter!";
                echo "<script>alert('$failed'); location.href = '../index.php';</script>";
            }

            $mail->smtpClose();
        }
    }
}

?>