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
        <title>CarMe Admin Login</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>

        <?php
            $username = $password = "";
            $upErr = $usernameErr = $passErr = "";
            $successMsg = "";

            if($_SERVER["REQUEST_METHOD"]=="POST")
            {
                //clean the data
                $username = $_POST["admin-username"];
                $password = $_POST["admin-password"];

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
                
                    $sql=mysqli_query($connection,"SELECT * FROM admin WHERE username='$username' and password= '$password' ");
                    $row  = mysqli_fetch_array($sql);
                    if(is_array($row))
                    {
                        if($row['username']== $username && $row['password']== $password)
                        {
                            $_SESSION["adminID"] = $row['adminID'];
                            $_SESSION["admin_fullname"] = $row['fullname'];
                            $_SESSION["admin_username"] = $row['username'];
                            $_SESSION["admin_email"]=$row['email'];
                            $_SESSION["admin_password"]=$row['password']; 

                            $successMsg = "You have successfully login as an admin.";
                            echo "<script>alert('$successMsg')</script>";
                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"../admin_dashboard/profile.php\";";
                            echo "</script>";
                        }
                        else
                        {
                            $conErr = "Failed to login as an admin.";
                            echo "<script>alert('$conErr')</script>";
                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"../admin_dashboard/profile.php\";";
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
            <h2>For CarMe ADMIN login only:</h2>
        </div>
            
        <div class="al-form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <div class="user-image">
                    <img src="../images/flaticon_robot.png" alt="">
                </div>
                <div class="al-input-box">
                    <span>Username</span>
                    <br>
                    <input type="text" name="admin-username" placeholder="Enter username">
                </div>

                <div class="al-input-box">
                    <span>Password</span>
                    <br>
                    <input type="password" name="admin-password" placeholder="Enter password">
                </div>
                
                <div class="buttons">
                    <a href="../index.php" class="al-cncl-button" id="al-cncl-button">Cancel</a>
                    <input type="submit" value="Log In" class="al-button" id="ml-button">
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
                
                <div class="qs">
                    <a href="admin_forgot_password.php" class="al-forgot-pw" id="al-forgot-pw">Forgot password?</a>
                </div>
            </form>
        </div>
        </div>
    </body>
</html>

