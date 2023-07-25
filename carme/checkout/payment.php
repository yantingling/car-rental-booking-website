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

if(isset($_SESSION["pay_fullname"]) && isset($_SESSION["pay_email"]))
{
  $full_name = $_SESSION["pay_fullname"];
  $email = $_SESSION["pay_email"];
}
?>

<?php
$NOC = $CCNum = $expmonth =$CVV = $expyr ="";
$NOCErr = $CCNumErr = $CVVErr = $expyrErr ="";
if (isset($_POST["pay"]))
{
    $NOC= $_POST["cardname"];
    $CCNum = $_POST["cardnumber"];
    $expmonth = $_POST["expmonth"];    
    $CVV= $_POST["cvv"];
    $expyr = $_POST["expyear"];

	if (empty($NOC))
    {
        $NOCErr = "Full Name is required, please re-enter.";
        $_SESSION["err2"]= $NOCErr;
    }
    elseif (empty($CCNum))
    {
        $CCNumErr = "Credit card number is required, please re-enter";
        $_SESSION["err2"]= $CCNumErr;
    } 
    elseif (!preg_match ("/^(?=.*?[0-9])\S{16}$/", $CCNum))
    {
        $CCNumErr = "Only 16 numbers, no spaces or dashes.";  
        $_SESSION["err2"]= $CCNumErr;

    }    elseif(empty($expyr))
    {
      $expyrErr = "Expiry year is required, please re-enter";
      $_SESSION["err2"]= $expyrErr;
    }
    elseif(!preg_match("/^(?=.*?[0-9])\S{4}$/", $expyr))
    {
      $expyrErr = "Expiry year contains 4 numbers only, please re-enter";
      $_SESSION["err2"]= $expyrErr;
    }
    elseif (empty($CVV))
    {
        $CVVErr = "CVV is required, please re-enter";
        $_SESSION["err2"]= $CVVErr;
    }
    elseif (!preg_match ("/^(?=.*?[0-9])\S{3}$/", $CVV))
    {
        $CVVErr = "Only 3 numbers and no spaces.";  
        $_SESSION["err2"]= $CVVErr;
    }
    else
    {        
        $id = $_SESSION['memberID'];
        $car = $_SESSION['carplateCO'];
        $loc = $_SESSION['locationCO'];
        $dt1 = $_SESSION["pudCO"];
        $dt2 = $_SESSION["dodCO"];
        $amt = $_SESSION["total_payment"];

        $sql1= "INSERT INTO booking (mem_ID, car, pick_up_date, drop_off_date, location) VALUES($id,'$car','$dt1','$dt2','$loc')";
      if (mysqli_query($connection, $sql1))
      {
        //getting the booking_id , because it is auto_incremented so i need to specify the details to get the specific one
        $sqll = "SELECT * FROM booking WHERE car='$car' AND location='$loc' AND pick_up_date= '$dt1' ";
        $result = mysqli_query($connection, $sqll);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $bookid = $row["book_ID"]; //for sql
        $_SESSION["b_id"] = $bookid; //for invoice later

        $dt = date('Y-m-d');

        $sql2 = "INSERT INTO transaction (booking_ID, pay_type, pay_amount, pay_date) VALUES ($bookid, 'Credit', $amt ,'$dt' )";
        if (mysqli_query($connection, $sql2))
        {
          #email
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
          $mail->Subject = 'Successful payment for Your Car Rental of ' .$car;
          $mail->Body =  "Dear " .$full_name. ",";
          $mail->Body .= "<br><br>You have successfully made your payment.<br><br>The following are your booking details:<br><br>";
          $mail->Body .= "Booking ID: #" .$bookid;
          $mail->Body .= "<br>Car Plate: " .$car;
          $mail->Body .= "<br>Pick-up and Drop-off Location: " .$loc;
          $mail->Body .= "<br>Pick-up Date: " .$dt1;
          $mail->Body .= "<br>Drop-off Date: " .$dt2;
          $mail->Body .= "<br>Payment Date " .$dt;
          $mail->Body .= "<br>Payment Amount: RM" .number_format($amt,2);
          $mail->Body .= "<br><br>Thank you for supporting CarMe!<br><br>Warmest Regards,<br><i>CarMe Admin</i>";

          if($mail->send())
          {
              $successMsg = "Successful payment! Please check your email for the booking details or continue here to print it.";
              echo "<script>alert('$successMsg'); location.href = 'invoice.php';</script>";
          }
          else
          {
              $failed = "Failed payment!";
              echo "<script>alert('$failed'); location.href = 'payment.php';</script>";

              $sqldlt = "DELETE FROM booking WHERE book_ID = '$bookid'";
              $sqldlt2 = "DELETE FROM transaction WHERE booking_ID = '$bookid'";
              mysqli_query($connection, $sqldlt); 
              mysqli_query($connection, $sqldlt2); 
          }

          $mail->smtpClose(); 
        } 
        else 
        {
          $failed = "Failed payment!";
          echo "<script>alert('$failed'); location.href = 'payment.php';</script>";
        }
      }
    }
     
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CarMe Payment</title>
      <link rel = "stylesheet" type = "text/css" href = "../css/payment.css">
      <!--Box Icons-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  </head>

  <body>

    <!--Header-->
    <header id="header">
      <a href="../index.php" class="logo"><img src="../images/CarMeLogo.png" alt="CarMe"></a>

      <div class="bx bx-menu" id="menu-icon"></div>

      <ul class="navbar">
        <li><a href="../index.php#home">Home</a></li>
        <li><a href="../index.php#guides">Guides</a></li>
        <li><a href="../index.php#services">Services</a></li>
        <li><a href="../index.php#cars">Cars</a></li>
        <li><a href="../index.php#about">About</a></li>
        <li><a href="../cart.php">Cart</a></li>
      </ul>

      <?php
        if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
        {
          echo('<div class="header-button"><a href="../login/member_login.php" class="login" id="login">Log In</a></div>');
        }
        else
        {
          echo ('<div title="Profile" class="bx bx-user-circle" id="user-icon"></div>');
        }
      ?>
    </header>

    <!--Member Account (ma) Dropdown Menu-->
    <div class="ma-dropdown" id="ma-dropdown">
      <div class="ma-dropdown-menu">
        <ul>
          <li><a href="../member_dashboard/profile.php">My Profile</a></li>
          <li><a href="../member_dashboard/bookings.php">My Bookings</a></li>
          <li><a href="../member_dashboard/rewards.php">My Rewards</a></li>
          <li><a href="../member_dashboard/member_logout.php">Log Out</a></li>
        </ul>
      </div>
    </div>
      
    <div class="main-content">
      <div class="payment-heading">
        <h2>Payment</h2>
      </div>

      <div class="grid-payment">
        <div class="payment-info">
          <div class="grid-content">
            <div class="grid-head">
              <span><b>Accepted Cards</b></span>
              <div class="icon-container">
                <img src="../images/acceptcardlebihsmaller.png" alt = "Card" >
              </div>
            </div>

            <div class="grid-body-payment">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">

                <div class="bk-input-box">
                  <span>Name on Card</span>
                  <br>
                  <input type="text" id="cname" name="cardname" placeholder="Enter name on card...">
                </div>

                <div class="bk-input-box">
                  <span>Credit/Debit card number</span>
                  <br>
                  <input type="text" id="ccnum" name="cardnumber" placeholder="Example: 1111222233334444">
                </div>

                <div class="bk-input-box">
                  <div class="column">
                    <span>Expiry Month</span>
                    <br>
                    <select name="expmonth">
                      <option>January</option>
                      <option>February</option>
                      <option>March</option>
                      <option>April</option>
                      <option>May</option>
                      <option>June</option>
                      <option>July</option>
                      <option>August</option>
                      <option>September</option>
                      <option>October</option>
                      <option>November</option>
                      <option>December</option>
                    </select>
                  </div>

                  <div class="column">
                    <span>Expiry Year</span>
                    <br>
                    <input type="number" id="expyear" name="expyear" placeholder="Example: 2023">
                  </div>

                  <div class="column">
                    <span>CVV</span>
                    <br>
                    <input type="text" id="cvv" name="cvv" placeholder="Example: 111">
                  </div>
                </div>

                <br>
                <?php

                  if(!empty($_SESSION["voucher"]) && $_SESSION["voucher"] = "WELCOME77")
                  {
                    echo "<p>";
                    echo "Amount Discounted (RM): <b>";
                    if (isset($_SESSION["priceCO"])) 
                    {
                      $_SESSION["discount"] = round(($_SESSION["priceCO"] * 20 / 100), 2);
                      $_SESSION["total_payment"] = ($_SESSION["priceCO"] - $_SESSION["discount"]);
                      echo number_format($_SESSION["discount"],2);
                      echo "</b>";
                      echo "</p>";

                      echo "<br><p>";
                      
                      echo "Total Payment (RM): <b>";
                      echo number_format($_SESSION["total_payment"],2);
                      echo "</b>";
                      echo "</p>";
                    }
                  }
                  else
                  {
                    echo "<p>Amount Discounted (RM): <b>0.00</b></p>";
                    echo "<p>Total Payment (RM): <b>";
                    if(isset($_SESSION["priceCO"]))
                    {
                      $_SESSION["total_payment"] = $_SESSION["priceCO"];
                      echo number_format($_SESSION["total_payment"],2);
                      echo "</b>";
                    }
                    echo "</p>";
                  }
                ?>

                <br>

                <div class="error-msg">
                  <p><?php 
                    if(isset($_SESSION["err2"]))
                    {
                      echo $_SESSION["err2"];
                      unset($_SESSION["err2"]);
                    }
                  ?></p>
                </div>

                <div class="pay-btn">
                  <input type="submit" value="Pay" name="pay">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>


    <!--Link to JavaScript-->
    <script type="text/javascript" src="../javascript/main.js"></script>

  </body>
</html>
