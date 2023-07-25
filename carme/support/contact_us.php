<?php
include "../config_php/configuration.php";
global $connection;
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Contact Us</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">

        <!--Box Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>

    <body>
        <div class="heading-text" id="heading-text">
            <h2>Contact CarMe regarding Your Issues:</h2>
        </div>

        <div class="cu-form-container">
            <form action="email_cu.php" method="POST">
                <div class="cu-input-box">
                    <span>Full name</span>
                    <br>
                    <input type="text" name="fname" placeholder="Enter Full Name" id="fname">
                </div>

                <div class="cu-input-box">
                    <span>E-mail</span>
                    <br>
                    <input type="text" name="email" placeholder="Enter E-mail" id="email">
                </div>

                <div class="cu-input-box">
                    <span>Message</span>
                    <br>
                    <textarea name="message" placeholder="Write here..." id="message"></textarea>
                </div>

                <div class="buttons">
                    <a href="../index.php" class="cu-cncl-button" id="cu-cncl-button">Cancel</a>
                    <input type="submit" value="Submit" class="cu-button" id="cu-button">
                </div>

                <div class="regi-msg">
                    <p><?php

                        session_start();

                        if(isset($_SESSION["emailErr"]))
                        {
                            echo $_SESSION["emailErr"];
                            unset($_SESSION["emailErr"]);
                        }
                        elseif(isset($_SESSION["fnameErr"]))
                        {
                            echo $_SESSION["fnameErr"];
                            unset($_SESSION["fnameErr"]);
                        }   
                        elseif(isset($_SESSION["messageErr"]))
                        {
                            echo $_SESSION["messageErr"];
                            unset($_SESSION["messageErr"]);
                        }
                        elseif(isset($_SESSION["successEmail"]))
                        {
                            echo $_SESSION["successEmail"];
                            unset($_SESSION["successEmail"]);
                        }
                    ?></p>
                </div> 
            </form>
        </div>
    </body>
</html>

