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
        <title>CarMe Member's Dashboard</title>

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
                    <h2>My Rewards</h2>
                </div>

                <div class="grid">
                    <div class="personal-info">
                        <div class="grid-content">
                            <div class="grid-head">
                                <span>Vouchers</span>
                                <br>
                                <p>Redeem the following voucher to receive valuable discount<p>
                                <br>
                                <br>
                                <a class="voucher-btn" href = "vouchers.html" target="_blank">Voucher</a>
                                
                            </div>
                        </div>
                    </div>
                </div>

        <!--Link to JavaScript-->
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