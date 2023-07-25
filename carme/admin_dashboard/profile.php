<?php
session_start();
include "../config_php/configuration.php";

if(isset($_SESSION["adminID"]) && isset($_SESSION["admin_username"]))
{
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="CarMe Admin Dashboard">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Admin Dashboard</title>

        <!--Styles-->
        <link rel="stylesheet" href="../css/admin_dashboard.css">

        <!--Box Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>

    <body>
        <header class="header-bar">
            <h3>
                <label for="">
                    <a class="bx bxs-dashboard" id="admin_dashboard" onclick="openSideBar()"></a>
                </label>

                Dashboard
            </h3>
        </header>

        <div class="sidebar" id="sidebar">
            <div class="avatar-wrapper">
                <img src="../images/flaticon_robot.png" alt="admin avatar">
                <h4>
                    <?php
                        echo $_SESSION["admin_username"];
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
                        <a href="cars.php"><span class="bx bxs-car" id="cars-icon"></span>
                        <span>Cars</span></a>
                    </li>

                    <li>
                        <a href="members.php"><span class="bx bxs-face" id="members-icon"></span>
                        <span>Members</span></a>
                    </li>

                    <li>
                        <a href="transactions.php"><span class='bx bx-bar-chart-square' id="transactions-icon"></span>
                        <span>Transactions</span></a>
                    </li>

                    <li>
                        <a href="admin_logout.php"><span class='bx bx-log-out' id="logout-icon"></span>
                        <span>Log Out</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content">

            <div class="profile">
                <div class="page-header-profile">
                    <h2>My Profile</h2>
                    <div class="edit-profile-button" id="edit-profile-button">
                        <a href="edit_profile.php?key_id=<?php echo $_SESSION["adminID"];?>" class="edit-prof" id="edit-prof"><button>Edit Profile<i class="bx bxs-edit" id="edit"></i></button></a>
                    </div>
                </div>

                <div class="grid">
                    <div class="admin-info">
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
                                        <th>Admin ID:</th>
                                        <td>
                                            <span><?php echo $_SESSION["adminID"];?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Full Name:</th>
                                        <td>
                                            <span><?php echo $_SESSION["admin_fullname"];?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>E-mail:</th>
                                        <td>
                                            <span><?php echo $_SESSION["admin_email"];?></span>
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
                                            <span><?php echo $_SESSION["admin_username"];?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Password:</th>
                                        <td>
                                            <span><?php echo $_SESSION["admin_password"];?></span>
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
                var dashboardIcon = document.getElementById("admin_dashboard");

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