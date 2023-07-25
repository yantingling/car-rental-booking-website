<?php
session_start();
include "../config_php/configuration.php";

if(isset($_SESSION["adminID"]) && isset($_SESSION["admin_username"]))
{
?>

<?php
    function allthedata($sql)
    {
        global $connection;
        $output = "";
        $totalSales = 0;
    
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            $output .='
            <tr>
                <td>'.$row["trans_ID"].'</td>
                <td>'.$row["booking_ID"].'</td>
                <td>'.$row["mem_ID"].'</td>
                <td>'.$row["car"].'</td>
                <td>'.$row["pay_type"].'</td>
                <td>'.$row["pay_date"].'</td>
                <td>'.$row["pay_amount"].'</td>
            </tr> 
            ';
            $totalSales += $row["pay_amount"];
        }//while
        
        $output .='
            <tr>
                <td colspan="6"><b><i>Total Sales</i></b></td>
                
                <td>'.$totalSales.'</td>
            </tr> 
        ';
            return $output;
    }

    $reportshow = '';
    $dt1= $dt2='';
    if(isset($_POST['update_table'])) 
    {
        $input_error = false;
        $msg = "";
        $dt1=$_POST['datefrom'];
        $dt2=$_POST['dateTo'];

        if(strlen($dt1) >5)
        { // if from date is filled 
            $date = new DateTime($dt1);
            $dt1=$date->format('Y-m-d'); // To match MySQL date format
    //        $sql= " AND dt >='$dt1'  " ;
        }
        if(strlen($dt2) >5)
        { // if to date is filled
            $date = new DateTime($dt2);
            $dt2=$date->format('Y-m-d'); // To match MySQL date format
    //        $sql= " AND dt <= '$dt2'  " ;
        }
        $newDatefrom = date("Y-m-d", strtotime($dt1));
        $dateFrom = $newDatefrom;

        $newDateTo = date("Y-m-d", strtotime($dt2));
        $dateTo = $newDateTo;

        $sql = "SELECT t.trans_ID ,t.booking_ID ,t.pay_type ,t.pay_amount, t.pay_date, b.mem_ID, b.car FROM transaction AS t INNER JOIN booking as b ON t.booking_ID = b.book_ID WHERE t.pay_date BETWEEN '$dateFrom' AND '$dateTo' ";
        $result_print = allthedata($sql);
    }
    else
    {
        $sql = "SELECT t.trans_ID ,t.booking_ID ,t.pay_type ,t.pay_amount, t.pay_date, b.mem_ID, b.car FROM transaction AS t INNER JOIN booking as b ON t.booking_ID = b.book_ID ";
        $result_print = allthedata($sql);
    }
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
        <header id="header-bar">
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

            <div class="transaction" id="page-header">
                <div class="page-header-trans">
                    <h2>Transactions Summary</h2>
                </div>
            </div>

            <div class="grid-trans">
                <div class="transaction-info">
                    <div class="grid-content">
                        <div class="grid-head" id="content-head">
                            <span>Transaction Details</span>
                            <br>
                            <p>View CarMe total revenue here</p>

                            <!-- Selecting data -->
                            <div class="search-container">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <label><span>Start Date:</span></label>
                                    <input type="date" name="datefrom" placeholder="Start Date">

                                    <label><span>End Date:</span></label>
                                    <input type="date" name="dateTo" placeholder="Start Date">
                                        
                                    <label for="update_table">&nbsp;</label>
                                    <input type="submit" name="update_table" value="Search" class="search-btn">

                                    <label for="generate_transaction_report">&nbsp;</label>
                                    <button class="report-btn" onclick="printTransaction()">Print Report</button>
                                </form>
                            </div>
                        </div>

                        <br>

                        <div class="grid-body-transaction" id="to-print">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Booking ID</th>
                                        <th>Member ID</th>
                                        <th>Car Plate</th>
                                        <th>Payment Type</th>
                                        <th style="width: 130px;">Date</th>
                                        <th>Payment Amount (RM)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php echo $result_print; ?>
                                </tbody>
                            </table>
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

            function printTransaction()
            {
                var headerBar = document.getElementById("header-bar");
                var contentHead = document.getElementById("content-head");

                headerBar.style.display = "none";
                contentHead.style.display = "none";

                window.print();
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