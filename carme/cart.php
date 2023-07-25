<?php
include "config_php/configuration.php";
global $connection;
session_start();

if(!empty($_GET["action"])) 
{
    switch($_GET["action"]) 
    {
        case "add":
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (!empty($_POST["numDays"])) 
                {
                    $sqlretrieve = "SELECT * FROM cars WHERE carplate = '" . $_GET["carplate"] . "'";
                    $result = mysqli_query($connection, $sqlretrieve);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $brand = $row['brand'];
                    $model = $row['model'];
                    $carplate = $row['carplate'];
                    $location = $row['location'];
                    $price = $row['price'];
                    $image = $row['image'];

                    $carArray = array(
                        $carplate => array(
                            'brand' => $brand,
                            'model' => $model,
                            'carplate' => $carplate,
                            'price' => $price,
                            'location' => $location,
                            'pickupDate' => $_POST["pudCart"],
                            'dropoffDate' => $_POST["dodCart"],
                            'numDays' => $_POST["numDays"],
                            'totalPrice' => $_POST["numDays"] * $price,
                            'image' => $image
                        )
                    );

                    if (empty($_SESSION["shopping_cart"])) {
                        $_SESSION["shopping_cart"] = $carArray;
                        $status = "Desired car is added to your cart!";
                        echo "<script>alert('$status')</script>";
                        echo "<script type=\"text/javascript\">";
                        echo "window.location = \"cart.php\";";
                        echo "</script>";
                    } else {
                        $array_keys = array_keys($_SESSION["shopping_cart"]);
                        if (in_array($carplate, $array_keys)) {
                            $status = "The car is already added to your cart!";
                            echo "<script>alert('$status')</script>";
                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"cart.php\";";
                            echo "</script>";
                        } else {
                            $_SESSION["shopping_cart"] = array_merge(
                                $_SESSION["shopping_cart"],
                                $carArray
                            );
                            $status = "Desired car is added to your cart!";
                            echo "<script>alert('$status')</script>";
                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"cart.php\";";
                            echo "</script>";
                        }

                    }
                }
                else
                {
                    $status = "Failed to add car to your cart!";
                    echo "<script>alert('$status')</script>";
                    echo "<script type=\"text/javascript\">";
                    echo "window.location = \"cart.php\";";
                    echo "</script>";
                }
            }
            break;

        case "remove":
            if (!empty($_SESSION["shopping_cart"])) 
            {
                foreach ($_SESSION["shopping_cart"] as $key => $value) {
                    if ($_GET["carplate"] == $key) {
                        unset($_SESSION["shopping_cart"][$key]);
                        $status = "Product is removed from your cart!";
                        echo "<script>alert('$status')</script>";
                        echo "<script type=\"text/javascript\">";
                        echo "window.location = \"cart.php\";";
                        echo "</script>";
                    }
                    if(empty($_SESSION["shopping_cart"]))
                    {
                        unset($_SESSION["shopping_cart"]);
                    }
                }
            }	
            break;

        case "empty":
            unset($_SESSION["shopping_cart"]);
            break;	
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Cart</title>

        <!-- Stylesheet -->
        <link rel="stylesheet" href="css/cart.css"/>

        <!--Box Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>

    <body>
        <!--Header-->
        <header id="header">
            <a href="index.php" class="logo"><img src="images/CarMeLogo.png" alt="CarMe"></a>

            <div class="bx bx-menu" id="menu-icon"></div>

            <ul class="navbar">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#guides">Guides</a></li>
                <li><a href="index.php#services">Services</a></li>
                <li><a href="index.php#cars">Cars</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="cart.php">Cart</a></li>
            </ul>

            <?php
                if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
                {
                    echo('<div class="header-button"><a href="login/member_login.php" class="login" id="login">Log In</a></div>');
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
                    <li><a href="member_dashboard/profile.php">My Profile</a></li>
                    <li><a href="member_dashboard/bookings.php">My Bookings</a></li>
                    <li><a href="member_dashboard/rewards.php">My Rewards</a></li>
                    <li><a href="member_dashboard/member_logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>

        <div class="cart" id="cart">
            <div class="cart-heading">
                    <h2>Shopping Cart</h2>
                    <div class="empty-cart-btn" id="empty-cart-btn">
                        <a href="cart.php?action=empty" class="empty-cart" id="empty-cart"><button>Empty Cart<i class="bx bxs-trash" id="trashIcon"></i></button></a>
                    </div>
            </div>

            <div class="cart-grid">
                <div class="grid-content">
                    <div class="cart-table">
                        <?php
                            if(isset($_SESSION["shopping_cart"]))
                            {
                                $total_price = 0;
                        ?>	
                                <table class="table-cart" cellpadding="10" cellspacing="1">
                                    <thead>
                                        <tr>
                                        <th>Car Name</th>
                                        <th>Car Plate</th>
                                        <th>Pick-Up Date</th>
                                        <th>Drop-Off Date</th>
                                        <th>Location</th>
                                        <th>Number of Days</th>
                                        <th>Daily Rental Rate (RM)</th>
                                        <th>Rental Price (RM)</th>
                                        <th style="width: 150px">Actions</th>
                                        </tr>
                                    </thead>
                        <?php		
                                foreach ($_SESSION["shopping_cart"] as $item){
                                    ?>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <img style="width: 80px" src="images/<?php echo $item['image']; ?>" class="cart-item-image" />
                                                        <br>
                                                        <?php echo "".$item['brand']. " " .$item['model']. ""; ?>
                                                    </td>
                                                    <td><?php echo $item["carplate"]; ?></td>
                                                    <td><?php echo $item["pickupDate"]; ?></td>
                                                    <td><?php echo $item["dropoffDate"]; ?></td>
                                                    <td><?php echo $item["location"]; ?></td>
                                                    <td><?php echo $item["numDays"]; ?></td>
                                                    <td><?php echo $item["price"]; ?></td>
                                                    <td><?php echo number_format($item["totalPrice"],2); ?></td>
                                                    <td>
                                                        <a href="checkout/confirm_checkout.php?carplate=<?php echo $item["carplate"]; ?>">
                                                            <button class="checkOutBtn">Check Out</button>
                                                        </a>
                                                        <br><br>
                                                        <a href="cart.php?action=remove&carplate=<?php echo $item["carplate"]; ?>" class="btnRemoveAction">
                                                            Remove
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $total_price += $item["totalPrice"];
                                    }
                                ?>

                                                <tr class="total">
                                                    <td colspan="7"><b><i>Total<i><b></td>
                                                    <td colspan="2"><strong><?php echo "RM ".number_format($total_price, 2); ?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                    </div>	

                    <?php
                        } 
                        else {
                    ?>
                            <div class="no-records">
                                <p>Your Cart is Empty!</p>
                            </div>
                    <?php 
                        }
                    ?>
                </div>
            </div>

            <!--Link to JavaScript-->
            <script type="text/javascript" src="javascript/main.js"></script>
    </body>
</html>