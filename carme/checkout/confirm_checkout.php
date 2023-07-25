<?php
session_start();
// Include config file
include "../config_php/configuration.php";
global $connection;

if (isset($_POST["checkout"]))
{
  $p_fullname = $_POST["fullname"];
  $p_email = $_POST["email"];
  $p_address = $_POST["address"];
  $p_address2 = $_POST["address2"];
  $p_city = $_POST["city"];
  $p_postcode = $_POST["postcode"];
  $p_state = $_POST["state"];
  $_SESSION["voucher"] = $_POST["voucher"];

  if (empty($p_fullname))
  {
    $fullnameErr = "Full Name is required, please re-enter.";
    $_SESSION["err"]= $fullnameErr;
    header("Location: confirm_checkout.php?carplate=" . $_SESSION['carplateCO']);
  }
  elseif (empty($p_email))
  {
    $emailErr = "Email is required, please re-enter.";
    $_SESSION["err"]=$emailErr;
    header("Location: confirm_checkout.php?carplate=" . $_SESSION['carplateCO']);
  }
  // check if e-mail address is in correct format
  elseif (!filter_var($p_email, FILTER_VALIDATE_EMAIL))
  {
    $emailErr = "Invalid email format, please re-enter.";
    $_SESSION["err"]=$emailErr;
    header("Location: confirm_checkout.php?carplate=" . $_SESSION['carplateCO']);
  }
  elseif (empty($p_address))
  {
    $addressErr = "At least 1 address line is required, please re-enter";
    $_SESSION["err"]=$addressErr;
    header("Location: confirm_checkout.php?carplate=" . $_SESSION['carplateCO']);
  }
  elseif (empty($p_postcode))
  {
    $postcodeErr = "postcodecode is required, please re-enter.";
    $_SESSION["err"]=$postcodeErr;
    header("Location: confirm_checkout.php?carplate=" . $_SESSION['carplateCO']);
  }
  elseif(!preg_match("/^(?=.*?[0-9])\S{5}$/", $p_postcode))
  {
    $postcodeErr = "Only 5 numbers for postcodecode and no spaces.";
    $_SESSION["err"]=$postcodeErr;
    header("Location: confirm_checkout.php?carplate=" . $_SESSION['carplateCO']);
  } 
  else
  {
    $_SESSION["pay_fullname"]=$p_fullname;
    $_SESSION["pay_email"]=$p_email;
    $_SESSION["pay_addr"]=$p_address;
    $_SESSION["pay_addr2"]=$p_address2;
    $_SESSION["pay_city"]=$p_city;
    $_SESSION["pay_state"]=$p_state;
    $_SESSION["pay_postcode"]=$p_postcode;

    if (isset($_SESSION["username"])) {
      header("Location: payment.php");
    }
    else
    {
      header("Location: ../login/member_login.php");
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
      <div class="checkout-heading">
        <h2>Checkout</h2>
      </div>
      
      <div class="grid-checkout">
        <div class="checkout-info">
          <div class="grid-content">
            <div class="grid-head">
              <span><b>Customer Details</b></span>
            </div>

            <div class="grid-body-checkout">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div class="bk-input-box">
                  <span>Full Name</span>
                  <br>
                  <input type="text" id="fname" name="fullname" placeholder="Enter full name..." value="<?php if (isset($_SESSION["pay_fullname"])) {echo $_SESSION["pay_fullname"];} ?>">
                </div>

                <div class="bk-input-box">
                  <span>Email</span>
                  <br>
                  <input type="text" id="email" name="email" placeholder="Enter E-mail..." value="<?php if (isset($_SESSION["pay_email"])) {echo $_SESSION["pay_email"];} ?>">
                </div>

                <div class="bk-input-box">
                  <span>Address</span>
                  <br>
                  <input type="text" id="adr" name="address" placeholder="Line 1" value="<?php if (isset($_SESSION["pay_addr"])) {echo $_SESSION["pay_addr"];} ?>">
                  <input type="text" id="adr2" name="address2" placeholder="Line 2" value="<?php if (isset($_SESSION["pay_addr2"])) {echo $_SESSION["pay_addr2"];} ?>"> 
                </div>

                <div class="bk-input-box">
                  <div class="column">
                    <span>City</span>
                    <br>
                    <input type="text" id="city" name="city" placeholder="Enter City..." value="<?php if (isset($_SESSION["pay_city"])) {echo $_SESSION["pay_city"];} ?>">
                  </div>
                  <div class="column">
                    <span>State</span>
                    <br>
                    <input type="text" id="state" name="state" placeholder="Enter State..." value="<?php if (isset($_SESSION["pay_state"])) {echo $_SESSION["pay_state"];} ?>">
                  </div>

                  <div class="column">
                    <span>Postcode</span>
                    <br>
                    <input type="text" id="postcode" name="postcode" placeholder="Enter Postcode..." value="<?php if (isset($_SESSION["pay_postcode"])) {echo $_SESSION["pay_postcode"];} ?>">
                  </div>
                </div>

                <div class="error-msg">
                  <p><?php 
                    if(isset($_SESSION["err"]))
                    {
                      echo $_SESSION["err"];
                      unset($_SESSION["err"]);
                    }
                  ?></p>
                </div>

                <br>

                <div class="bk-check-box">
                  <input type="checkbox" checked="checked" name="sameadr" required> By clicking the checkbox, you confirm that you have read, understood and agree to our <a href="../documents/CarMe_TnC.pdf" target="_blank">Terms & Conditions</a> and <a href="../documents/CarMe_privacy_policy.pdf" target="_blank">Privacy Policy</a>
                </div>

                <br><br><hr><br><br>

                <div class="bookingSummary">
                  <div class="grid-head">
                    <span><b>Booking Summary</b></span>
                  </div>

                  <div class="booking-content">
                    <?php 
                      if(isset($_SESSION["shopping_cart"]) && !empty($_GET["carplate"]))
                      {
                        foreach($_SESSION["shopping_cart"] as $item)
                        {
                          if($item["carplate"] == $_GET["carplate"])
                          {
                            $_SESSION["carplateCO"] = $item["carplate"];
                            $_SESSION["locationCO"] = $item["location"];
                            $_SESSION["pudCO"] = $item["pickupDate"];
                            $_SESSION["dodCO"] = $item["dropoffDate"];
                            $_SESSION["priceCO"] = $item["totalPrice"];
                    ?>
                            <p>Car Name: <span><?php echo "".$item['brand']. " " .$item['model']. ""; ?></span></p>
                            <p>Car Plate: <span><?php echo $item["carplate"]; ?></span></p>
                            <p>Pick-Up Date: <span><?php echo $item["pickupDate"]; ?></span></p>
                            <p>Drop-Off Date: <span><?php echo $item["dropoffDate"]; ?></span></p>
                            <p>Pick-Up & Drop-Off Location: <span><?php echo $item["location"]; ?></span></p>
                            <p>Total Rental Price (RM): <span><?php echo number_format($item["totalPrice"], 2); ?></span></p>
                            <p>Voucher Code: <span><input type=text name="voucher" id="voucher" value="<?php if (isset($_SESSION["voucher"])) {echo $_SESSION["voucher"];} ?>"></span></p>
                            <div class="btn">
                              <input type="submit" value="Continue to Checkout" name="checkout">
                            </div>
                    <?php
                          }
                        }
                      } 
                    ?> 
                  </div>
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