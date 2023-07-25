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

            <div class="registered-members">
                <div class="page-header-members">
                    <h2>All Registered CarMe Members</h2>
                    <div class="add-mbr-button" id="add-mbr-button">
                        <a href="add_members.php" class="add-mbr" id="add-mbr"><button>Add New Member <i class='bx bxs-plus-circle' id="addIcon"></i></button></a>
                    </div>
                </div>

                <div class="grid">
                    <div class="mbr-info">
                        <div class="grid-content">
                            <div class="grid-head">
                                <span>Members Information</span>
                                <br>
                                <p>Information about all the registered members at CarMe</p>
                            </div>

                            <br>

                            <div class="grid-body-mbr">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Member ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Confirmed Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM registration";
                                            global $connection;
                                            
                                            $result = mysqli_query($connection,$sql);
                                            
                                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                            {
                                                echo"<tr>";
                                                echo "<td>".$row["memberID"]."</td>";
                                                echo "<td>".$row["fullname"]."</td>";
                                                echo "<td>".$row["email"]."</td>";
                                                echo "<td>".$row["username"]."</td>";
                                                echo "<td>".$row["password"]."</td>";
                                                echo "<td>".$row["confirmpw"]."</td>";
                                        ?>
                                            <td>
                                                <a href="edit_members.php?key_id=<?php echo $row["memberID"];?>" class="edit-mbr-btn">Edit</a>
                                            </td>

                                        <?php 
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
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