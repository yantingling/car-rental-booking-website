<?php
session_start();
include "../config_php/configuration.php";
global $connection;
if(isset($_SESSION["username"]))
{
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="CarMe Member Dashboard">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Member's Profile</title>

        <!--Styles-->
        <link rel="stylesheet" href="../css/member_dashboard.css">

        <!--Box Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>

    <body>
        <header class="header-bar">
            <h3>
                <label for="">
                    <a class="bx bxs-dashboard" id="member_dashboard" onclick="openSideBar()"></a>
                </label>

                Dashboard
            </h3>

            <div class="home">
                <a href="../index.php"><span class="bx bxs-home" id="home"></span></a>
            </div>
        </header>

        <div class="sidebar" id="sidebar">
            <div class="avatar-wrapper">
                <img src="../images/flaticon_surprise.png" alt="member avatar">
                <h4>
                    <?php
                        echo $_SESSION["username"];
                    ?>
                </h4>
            </div>
                
            <hr>

            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="profile.php"><span class="bx bxs-user-circle" id="profile-icon"></span>
                        <span>Profile</span></a>
                    </li>
                    
                    <li>
                        <a href="bookings.php"><span class="bx bxs-shopping-bags" id="wishlist-icon"></span>
                        <span>Bookings</span></a>
                    </li>

                    <li>
                        <a href="rewards.php"><span class='bx bxs-box' id="box-icon"></span>
                        <span>Rewards</span></a>
                    </li>

                    <li>
                        <a href="member_logout.php"><span class='bx bx-log-out' id="logout-icon"></span>
                        <span>Log Out</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content">

            <div class="profile">
                <div class="page-header">
                    <h2>My Profile</h2>
                    <div class="edit-profile-button" id="edit-profile-button">
                        <a href="edit_profile.php?key_id=<?php echo $_SESSION["memberID"];?>" class="edit-prof" id="edit-prof"><button>Edit Profile<i class="bx bxs-edit" id="edit"></i></button></a>
                    </div>
                </div>

                <div class="grid">
                    <div class="personal-info">
                        <div class="grid-content">
                            <div class="grid-head">
                                <span>Personal Information</span>
                                <br>
                                <p>Information about you</p>
                            </div>

                            <br>

                            <div class="grid-body-profile">
                                <table>
                                    <tr>
                                        <th>Full Name:</th>
                                        <td>
                                            <span><?php echo $_SESSION["fullname"];?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>E-mail:</th>
                                        <td>
                                            <span><?php echo $_SESSION["email"];?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid">
                    <div class="login-info">
                        <div class="grid-content">
                            <div class="grid-head">
                                <span>Log In Information</span>
                                <br>
                                <p>Use these to log in into CarMe</p>
                            </div>

                            <br>

                            <div class="grid-body-profile">
                                <table>
                                    <tr>
                                        <th>Username:</th>
                                        <td>
                                            <span><?php echo $_SESSION["username"];?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Password:</th>
                                        <td>
                                            <span><?php echo $_SESSION["password"];?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Confirmed Password:</th>
                                        <td>
                                            <span><?php echo $_SESSION["confirmpw"];?></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!--JavaScript-->
        <script type="text/javascript">
            function openSideBar()
            {
                var dashboardMenu = document.getElementById("sidebar");
                var dashboardIcon = document.getElementById("member_dashboard");

                dashboardMenu.classList.toggle("showup");
                dashboardIcon.classList.toggle("rotateIcon");
            }
        </script>
    </body>
</html>

<?php
}
else
{
    header("Location: ../index.php");
    exit();
}
?>