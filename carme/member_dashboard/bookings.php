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
        <title>CarMe Member's Cart</title>

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

            <div class="booking">
                <div class="page-header">
                    <h2>My Bookings</h2>
                </div>

                <div class="grid">
                    <div class="booking-info">
                        <div class="grid-content">
                            <div class="grid-head">
                                <span>Booking Details Summary</span>
                                <br>
                                <p>View your past bookings here</p>
                            </div>
                            <br>

                            <div class="grid-body-booking">
                                <?php
                                    $id= $_SESSION["memberID"];
                                    $sql= "SELECT * FROM booking WHERE mem_ID='$id' ";
                                    $result=mysqli_query($connection, $sql);
                                    if(mysqli_num_rows($result) > 0)
                                    {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Booking ID</th>
                                                    <th>Car Plate Number</th>
                                                    <th>Location</th>
                                                    <th>Pick-Up Date</th>
                                                    <th>Drop-Off Date</th>
                                                    <th>Total Payment (RM)</th>
                                                    <th>Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                
                                <?php    
                                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                        {
                                            $bookingID = $row["book_ID"];

                                            echo"<tr>";
                                            echo "<td>".$row["book_ID"]."</td>";
                                            echo "<td>".$row["car"]."</td>";
                                            echo "<td>".$row["location"]."</td>";
                                            echo "<td>".$row["pick_up_date"]."</td>";
                                            echo "<td>".$row["drop_off_date"]."</td>";
                                            $sql2= "SELECT * FROM transaction WHERE booking_ID='$bookingID' ";
                                            $result2=mysqli_query($connection, $sql2);
                                            while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC))
                                            {
                                                echo "<td>".$row2["pay_amount"]."</td>";
                                                echo "<td>".$row2["pay_date"]."</td>";
                                            }
                                            echo"<tr>";
                                        }
                                ?>
                                        </tbody>
                                    </table>

                                <?php    
                                    }
                                    else
                                    {
                                ?>
                                        <div class="no-bookings">
                                            <br>
                                            <p>You haven't made any booking yet</p>
                                        </div>
                                <?php
                                    }
                                ?>
                                
                            </div>
                        </div>
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