<?php
include "../config_php/configuration.php";
global $connection;
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Member Registration</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>
        <?php
            $fname= $username = $email = $password= $confirmpw= "";
            $fnameErr= $usernameErr = $emailErr = $passErr = $conPassErr = "";
            $successMsg = $conErr = "";

            if($_SERVER["REQUEST_METHOD"] == "POST")
            {	
                $fname= $_POST["fname"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirmpw = $_POST["confirmpw"];

                if (empty($fname))
                {
                    $fnameErr = "Full Name is required, please re-enter.";
                }
                // check if username is alphanumeric
                elseif(!preg_match('/^[a-zA-Z][0-9a-zA-Z]{2,25}$/',$username )) 
                {

                    $usernameErr = "Minimum 3 alphanumeric characters, no spaces, please start with letters.";
                }   
                elseif (empty($email))
                {
                    $emailErr = "Email is required, please re-enter.";
                }
                // check if e-mail address is in correct format
                elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
                {   
                    $emailErr = "Invalid email format, please re-enter.";
                }
                elseif (empty( $password)) 
                {   
                    $passErr = "Password is required, please re-enter.";
                }
                // check if password is in correct format
                elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-])\S{6,30}$/",$password))
                {   
                    $passErr = "Minimum 6 characters, 1 digit, 1 uppercase letter, 1 special character and no spaces for password.";
                    
                }
                elseif($confirmpw != $password)
                {
                    $conPassErr = "The passwords do not match, please re-enter.";
                }
                else
                {
                    $sql1="SELECT * FROM registration WHERE username='$username'";
                    $result= mysqli_query($connection, $sql1);
                    if(mysqli_num_rows($result)>0)
                    {
                        $usernameErr = "This username is already taken. Try another.";
                    }
                    else
                    {
                        $sql ="INSERT INTO registration (fullname, username, email, password, confirmpw) VALUES('$fname', '$username', '$email', '$password', '$confirmpw')";
                    
                        if(mysqli_query($connection,$sql))
                        {
                            $successMsg = "Thank you for registering as a member! Your account has been created sucessfully.";
                            echo "<script>alert('$successMsg')</script>";
                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"../index.php\";";
                            echo "</script>";

                        }else
                        {
                            $failed = "Failed registration of member account. Please try again";
                        }
                    }
                    
                }
            }
        ?>

        <div class="heading-text" id="heading-text">
            <h2>CarMe Member Account Registration:</h2>
        </div>
            
        <div class="mr-form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                <div class="mr-input-box">
                    <span>Full name</span>
                    <br>
                    <input type="text" name="fname" placeholder="Enter Full Name" id="fname">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($fnameErr))
                            {
                                echo $fnameErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="mr-input-box">
                    <span>Username</span>
                    <br>
                    <input type="text" name="username" placeholder="Enter Username" id="username">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($usernameErr))
                            {
                                echo $usernameErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="mr-input-box">
                    <span>E-mail</span>
                    <br>
                    <input type="text" name="email" placeholder="Enter E-mail" id="email">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($emailErr))
                            {
                                echo $emailErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="mr-input-box">
                    <span>Password</span>
                    <br>
                    <input type="password" name="password" placeholder="Enter Password" id="password">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($passErr))
                            {
                                echo $passErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="mr-input-box">
                    <span>Confirm Password</span>
                    <br>
                    <input type="password" name="confirmpw" placeholder="Confirm Password" id="confirmpw">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($conPassErr))
                            {
                                echo $conPassErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="pp">
                    <p>By registering an account at CarMe, you agree to our
                        <a href="../documents/CarMe_privacy_policy.pdf" class="privacy-policy" target="_blank">
                            Privacy Policy</a></p>
                </div>
                
                <div class="buttons">
                    <a href="../index.php" class="mr-cncl-button" id="mr-cncl-button">Cancel</a>
                    <input type="submit" value="Register" class="mr-button" id="mr-button">
                </div>

                <div class="qs">
                    <a href="member_login.php" class="mr-had-acc" id="mr-had-acc">Already have an account?</a>
                </div>

                <div class="regi-msg">
                    <p><?php
                        if(!empty($failed))
                        {
                            echo $failed;
                        }
                    ?></p>
                </div>
            </form>
        </div>

    </body>
</html>