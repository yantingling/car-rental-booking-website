<?php
	include "../config_php/configuration.php";
	global $connection;
	$received_id = $_REQUEST['key_id'];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Edit Admin Profile</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>
        <?php
            session_start();

            $sqlretrieve = "SELECT * FROM admin WHERE adminID = '$received_id'";
            global $connection;

            $result = mysqli_query($connection, $sqlretrieve);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $adminID = $row["adminID"];
            $fname = $row["fullname"];
            $email = $row["email"];
            $username= $row["username"];
            $password = $row["password"];
        ?>

        <div class="heading-text" id="heading-text">
            <h2>Edit Admin Profile:</h2>
        </div>
            
        <div class="eap-form-container">
            <form action="validate_modify_admin.php?key_id=<?php echo $adminID;?>" method="POST">

                <div class="eap-input-box">
                    <span>Full name</span>
                    <br>
                    <input type="text" name="fname" placeholder="Enter Full Name" id="fname" value="<?php echo $fname;?>">
                    <div class="regi-msg">
                        <p><?php
                            if(isset($_SESSION["fnameErr"]))
                            {
                                echo $_SESSION["fnameErr"];
                                unset($_SESSION["fnameErr"]);
                            }
                        ?></p>
                    </div>
                </div>

                <div class="eap-input-box">
                    <span>Username</span>
                    <br>
                    <input type="text" name="username" placeholder="Enter Username" id="username" value="<?php echo $username;?>">
                    <div class="regi-msg">
                        <p><?php
                            if(isset($_SESSION["usernameErr"]))
                            {
                                echo $_SESSION["usernameErr"];
                                unset($_SESSION["usernameErr"]);
                            }
                        ?></p>
                    </div>
                </div>

                <div class="eap-input-box">
                    <span>E-mail</span>
                    <br>
                    <input type="text" name="email" placeholder="Enter E-mail" id="email" value="<?php echo $email;?>">
                    <div class="regi-msg">
                        <p><?php
                            if(isset($_SESSION["emailErr"]))
                            {
                                echo $_SESSION["emailErr"];
                                unset($_SESSION["emailErr"]);
                            }
                        ?></p>
                    </div>
                </div>

                <div class="eap-input-box">
                    <span>Password</span>
                    <br>
                    <input type="password" name="password" placeholder="Enter Password" id="password" value="<?php echo $password;?>">
                    <div class="regi-msg">
                        <p><?php
                            if(isset($_SESSION["passErr"]))
                            {
                                echo $_SESSION["passErr"];
                                unset($_SESSION["passErr"]);
                            }
                        ?></p>
                    </div>
                </div>
                
                <div class="buttons">
                    <a href="profile.php" class="eap-cncl-button" id="eap-cncl-button">Cancel</a>
                    <input type="submit" value="Update Profile" name="update" class="eap-button" id="eap-button">
                </div>
            </form>
        </div>
    </body>
</html>