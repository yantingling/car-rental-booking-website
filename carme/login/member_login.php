<?php
    session_start();
    // Include config file
    include "../config_php/configuration.php";

    global $connection;
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Member Login</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>
        <?php
            $username = $password = "";
            $upErr = $usernameErr = $passErr = "";
            $successMsg = $verifyml = "";

            if($_SERVER["REQUEST_METHOD"]=="POST")
            {
                //clean the data
                $username = trim($_POST["member-username"]);
                $password = trim($_POST["member-password"]);

                //check if username and password are empty
                if(empty($password) && empty($username))
                {
                    $upErr = "Please enter a username and password.";
                }
                // Check if username is empty
                elseif(empty($username))
                {
                    $usernameErr = "Please enter a username.";
                }
                // Check if password is empty
                elseif(empty($password))
                {
                    $passErr = "Please enter a password.";
                }
                else
                {
                // Verify credentials
                
                    $sql=mysqli_query($connection,"SELECT * FROM registration WHERE username='$username' and password= '$password' ");
                    $row  = mysqli_fetch_array($sql);
                    if(is_array($row))
                    {
                        if($row['username']== $username && $row['password']== $password)
                        {
                            $_SESSION["memberID"] = $row['memberID'];
                            $_SESSION["fullname"] = $row['fullname'];
                            $_SESSION["username"] = $row['username'];
                            $_SESSION["email"]=$row['email'];
                            $_SESSION["password"]=$row['password'];
                            $_SESSION["confirmpw"]=$row['confirmpw'];

                            $successMsg = "You have successfully login as a member.";
                            echo "<script>alert('$successMsg')</script>";
                            echo "<script type=\"text/javascript\">";
                            if(isset($_SESSION["carplateCO"]))
                            {
                                echo "window.location = \"../checkout/confirm_checkout.php?carplate=".$_SESSION['carplateCO']."\";";
                            }
                            else
                            {
                                echo "window.location = \"../index.php\";";
                            }
                            echo "</script>";
                        }
                        else
                        {
                            $conErr = "Failed to login as a member.";
                            echo "<script>alert('$conErr')</script>";
                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"../index.php\";";
                            echo "</script>";
                        }
                    }
                    else
                    {
                        $upErr = "Invalid Username or Password.";
                    }
                }
            }
        ?>

        <div class="heading-text" id="heading-text">
            <h2>For CarMe MEMBER login only:</h2>
        </div>
            
        <div class="ml-form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="user-image">
                    <img src="../images/flaticon_surprise.png" alt="">
                </div>
                <div class="ml-input-box">
                    <span>Username</span>
                    <br>
                    <input type="text" name="member-username" placeholder="Enter username">
                </div>

                <div class="ml-input-box">
                    <span>Password</span>
                    <br>
                    <input type="password" name="member-password" placeholder="Enter password">
                </div>
                
                <div class="buttons">
                    <a href="../index.php" class="ml-cncl-button" id="ml-cncl-button">Cancel</a>
                    <input type="submit" value="Log In" class="ml-button" id="ml-button">
                </div>

                <div class="regi-msg">
                    <p><?php
                        if(!empty($upErr))
                        {
                            echo $upErr;
                        }
                        elseif(!empty($usernameErr))
                        {
                            echo $usernameErr;
                        }   
                        elseif(!empty($passErr))
                        {
                            echo $passErr;
                        }
                    ?></p>
                </div> 
                
                <div class="ad-button">
                    <a href="admin_login.php" class="ru-admin" id="ru-admin">Are you CarMe ADMIN?</a>
                </div>
                
                <div class="qs">
                    <a href="member_registration.php" class="ml-register" id="ml-register">Not yet registered?</a>
                    <a href="member_forgot_password.php" class="ml-forgot-pw" id="ml-forgot-pw">Forgot password?</a>
                </div>
                
            </form>
        </div>
    </body>
</html>

