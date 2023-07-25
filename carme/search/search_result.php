<?php
include "../config_php/configuration.php";
global $connection;
session_start();

$now = new DateTime();
$todayDate = $now->format('Y-m-d');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST['loc']))
    {
        $error = "Location is not chosen yet. Please re-enter.";
        echo "<script>alert('$error')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    elseif(empty($_POST['pud']) || empty($_POST['dod']))
    {
        $error = "Pick-up or Drop-off date is not chosen yet. Please re-enter.";
        echo "<script>alert('$error')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    elseif($_POST["pud"]<$todayDate)
    {
        $error = "Pick-up date chosen has passed. Please re-enter.";
        echo "<script>alert('$error')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    elseif($_POST["dod"]<$todayDate)
    {
        $error = "Drop-off date chosen has passed. Please re-enter.";
        echo "<script>alert('$error')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    elseif($_POST["dod"]<$_POST["pud"])
    {
        $error = "Drop-off date should not be earlier than Pick-up date. Please re-enter.";
        echo "<script>alert('$error')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"../index.php\";";
        echo "</script>";
    }
    else
    {
        $_SESSION["location"] = $_POST['loc'];
        $location = $_SESSION["location"];
        $_SESSION["pickupdate"] = $_POST['pud'];
        $_SESSION["dropoffdate"] = $_POST['dod'];
        function dateDiffInDays($date1, $date2)
        {
            // Calculating the difference in timestamps
            $diff = strtotime($date2) - strtotime($date1);

            // 1 day = 24 hours
            // 24 * 60 * 60 = 86400 seconds
            return abs(round($diff / 86400));
        }

        $numDays = (dateDiffInDays(($_POST["pud"]), ($_POST["dod"])));

        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Search Cars</title>

        <!-- Stylesheet -->
        <link rel="stylesheet" href="../css/search.css" />

        <!--Box Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>
    
    <body>

        <!--Header-->
        <header id="header">
            <a href="../index.php" class="logo"><img src="../images/CarMeLogo.png" alt="CarMe"></a>

            <div class="bx bx-menu" id="menu-icon"></div>

            <ul class="navbar">
                <li><a href="../index.php#home">Home</a></li>
                <li><a href="../index.php#guides">Guides</a></li>
                <li><a href="../index.php#services">Services</a></li>
                <li><a href="../index.php#cars">Cars</a></li>
                <li><a href="../index.php#about">About</a></li>
                <li><a href="../cart.php">Cart</a></li>
            </ul>

            <?php
                if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
                {
                    echo('<div class="header-button"><a href="../login/member_login.php" class="login" id="login">Log In</a></div>');
                }
                else
                {
                    echo ('<div title="Profile" class="bx bx-user-circle" id="user-icon"></div>');
                }
            ?>
        </header>

        <!--Member Account (ma) Dropdown Menu-->
        <div class="ma-dropdown" id="ma-dropdown">
            <div class="ma-dropdown-menu">
                <ul>
                    <li><a href="../member_dashboard/profile.php">My Profile</a></li>
                    <li><a href="../member_dashboard/bookings.php">My Bookings</a></li>
                    <li><a href="../member_dashboard/rewards.php">My Rewards</a></li>
                    <li><a href="../member_dashboard/member_logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>

        <div class="entered_field" id="entered_field">
            <ul class="choices">
                <li class="a"><span><?php echo $_SESSION["pickupdate"]. " <i class='bx bx-right-arrow-alt' id='arrowIcon'></i> " .$_SESSION["dropoffdate"];?></span></li>
                <li><span>
                    <?php 
                        if(!empty($_SESSION["location"]) && ($_SESSION["location"] == "KIA"))
                        {
                            echo "Kuching International Airport";
                        }
                        elseif(!empty($_SESSION["location"]) && ($_SESSION["location"] == "SA"))
                        {
                            echo "Sibu Airport";
                        };
                    ?></span>
                </li>
            </ul>

            <div class="edit-choice-button">
                <a href="../index.php#search" class="edit-choice"><i class="bx bxs-edit" id="editIcon"></i></a>
            </div>
        </div>

        <div class="filter" id="filter">
            <div class="filter-menu">
                <ul>
                    <li>
                        <div class="Brands">
                            <div class="filter-text">
                                <span>Brands</span>
                            </div>

                            <div class="checkbox">
                                <label class="prt"><input type="checkbox" rel="Proton" onchange="change();"/>
                                    Proton
                                </label>
                            </div>

                            <div class="checkbox">
                                <label class="prd"><input type="checkbox" rel="Perodua" onchange="change();"/>
                                    Perodua
                                </label>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="Types">
                            <div class="filter-text">
                                <span>Types</span>
                            </div>

                            <div class="checkbox">
                                <label class="htb"><input type="checkbox" rel="Hatchback" onchange="change();"/>
                                    Hatchback
                                </label>
                            </div>

                            <div class="checkbox">
                                <label class="sdn"><input type="checkbox" rel="Sedan" onchange="change();"/>
                                    Sedan
                                </label>
                            </div>

                            <div class="checkbox">
                                <label class="suv"><input type="checkbox" rel="SUV" onchange="change();"/>
                                SUV
                                </label>
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <div class="Seaters">
                            <div class="filter-text">
                                <span>Seaters</span>
                            </div>

                            <div class="checkbox">
                                <label class="fs"><input type="checkbox" rel="5seaters" onchange="change();"/>
                                    5 Seaters
                                </label>
                            </div>
                            
                            <div class="checkbox">
                                <label class="ss"><input type="checkbox" rel="7seaters" onchange="change();"/>
                                    7 Seaters
                                </label>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!--Available Cars-->
        <div class="main-content">
            <div class="result">
                <?php
                    if (!empty($location)) 
                    {
                        $sqlretrieve = "SELECT * FROM cars WHERE location = '$location' ORDER BY price ASC";

                        $result = mysqli_query($connection, $sqlretrieve);

                        if (mysqli_num_rows($result) > 0) 
                        {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                            {

                                ?>
                                    <div class="filterDiv <?php echo $row['brand'] . ' ' . $row['model'] . ' ' . $row['type'] . ' ' . $row['seater'] . 'seaters'; ?>">
                                        <form method="post" action="../cart.php?action=add&carplate=<?php echo $row['carplate'];?>">
                                            <div class='cars-img'>
                                                <img src="../images/<?php echo $row['image'];?>" alt="CarMe cars">
                                            </div>
                                        
                                            <h2><?php echo $row['brand'] . ' ' . $row['model']; ?></h2>
                                            <h3><?php echo $row['type'] . ' | ' . $row['seater'] . ' seaters'; ?></h3>
                                            <p>RM<?php echo $row['price']; ?>/day</p>
                                            <input type="date" class="pudCart" name="pudCart" value="<?php if (!empty($_SESSION['pickupdate'])) {echo $_SESSION['pickupdate'];}?>" hidden>
                                            <input type="date" class="dodCart" name="dodCart" value="<?php if (!empty($_SESSION['dropoffdate'])) {echo $_SESSION['dropoffdate'];}?>" hidden>
                                            <input type="number" class="days" name="numDays" value="<?php if (!empty($numDays)) {echo $numDays;}?>" hidden>
                                            <input type="submit" class="addCartBtn" name="add-to-cart" value="Add to Cart">
                                        </form>
                                    </div>
                <?php
                            }
                        }
                    }
                ?>
            </div>
        </div>

        <!--Link to JavaScript-->
        <script type="text/javascript" src="../javascript/main.js"></script>
        <script  src="../javascript/search.js"></script>

        <script>
            window.onscroll = function() {myFunction()};

            var searchResult = document.getElementById("entered_field");
            var filterMenu = document.getElementById("filter");
            var sticky = searchResult.offsetTop;

            function myFunction() {
            if (window.pageYOffset >= sticky)
            {
                searchResult.classList.add("sticky")
                filterMenu.classList.add("fixed");
            }
            else
            {
                searchResult.classList.remove("sticky");
                filterMenu.classList.remove("fixed");
            }
            }
        </script>
    </body>
</html>
