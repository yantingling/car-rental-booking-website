<?php
session_start();
include "../config_php/configuration.php";
global $connection;
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Member Forgot Password</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>

        <div class="heading-text" id="heading-text">
            <h2>MEMBER: Forgot Password?</h2>
        </div>

        <div class="fp-form-container">
            <form action="email_mfp.php" method="POST">
                <div class="fp-input-box">
                    <span>Username</span>
                    <br>
                    <input type="text" name="fp-username" placeholder="Enter username">
                </div>
                <div class="fp-input-box">
                    <span>E-mail</span>
                    <br>
                    <input type="text" name="fp-email" placeholder="Enter E-mail">
                </div>
                <div class="buttons">
                    <a href="member_login.php" class="fp-cncl-button" id="fp-cncl-button">Back to Log In</a>
                    <input type="submit" value="Request Password" class="fp-button" id="fp-button">
                </div>

                <div class="regi-msg">
                    <p><?php
                        if(isset($_SESSION["bothErr"]))
                        {
                            echo $_SESSION["bothErr"];
                            unset($_SESSION["bothErr"]);
                        }
                        elseif(isset($_SESSION["usernameErr"]))
                        {
                            echo $_SESSION["usernameErr"];
                            unset($_SESSION["usernameErr"]);
                        }
                        elseif(isset($_SESSION["emailErr"]))
                        {
                            echo $_SESSION["emailErr"];
                            unset($_SESSION["emailErr"]);
                        }
                        elseif(isset($_SESSION["messageErr"]))
                        {
                            echo $_SESSION["messageErr"];
                            unset($_SESSION["usernameErr"]);
                        }
                        elseif(isset($_SESSION["successMsg"]))
                        {
                            echo $_SESSION["successMsg"];
                            unset($_SESSION["successMsg"]);
                        }
                    ?></p>
                </div> 
            </form>
        </div>
    </body>
</html>

