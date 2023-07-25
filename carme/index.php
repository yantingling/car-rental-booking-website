<?php
include "config_php/configuration.php";
global $connection;
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="keywords" content="car rental service, car rental, car, rent car">
        <meta name="description" content="Car Rental Service in Malaysia">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="css/styles.css">

        <!--Box Icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    </head>

    <body>
        <!--Header-->
        <header>
            <a href="#" class="logo"><img src="images/CarMeLogo.png" alt="CarMe"></a>

            <div class="bx bx-menu" id="menu-icon"></div>

            <ul class="navbar">
                <li><a href="#home">Home</a></li>
                <li><a href="#guides">Guides</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#cars">Cars</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="cart.php">Cart</a></li>
            </ul>
            
            <?php
                if(!isset($_SESSION["username"]) || empty($_SESSION["username"]))
                {
                    echo('<div class="header-button"><a href="login/member_login.php" class="login" id="login">Log In</a></div>');
                }
                else
                {
                    echo ('<div class="bx bx-user-circle" id="user-icon"></div>');
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

        <!--Home-->
        <section class="home" id="home">
            <div class="text">
                <h1><span>Looking to</span> <br>rent a car?</h1>
                <p>Car Rental made easy with CarMe.</p>
            </div>
            <div class="bg-img">
                <img src="images/undraw_car.svg" alt="background image">
            </div>
        </section>

        <!--Search Cars-->
        <section class="search" id="search">
            <div class="form-container">
                <div class="heading">
                    <p>Search</p>
                    <h1>Find Your Desired Cars</h1>
                </div>
                <br><br>
                <form action="search/search_result.php" method="POST">
                    <div class="input-box">
                        <span>Pick-Up and Drop-Off Location</span>
                        <select class="loc" id="loc" name="loc">
                            <option value="" disabled <?php if (empty($_SESSION["location"])) {
                                echo "selected";
                                unset($_SESSION["location"]);}?> hidden>Choose Pick-Up Location</option>
                            <option value="KIA" <?php if (!empty($_SESSION["location"]) && ($_SESSION["location"] == "KIA")) {echo "selected"; unset($_SESSION["location"]);} ?>>Kuching International Airport</option>
                            <option value="SA" <?php if (!empty($_SESSION["location"]) && ($_SESSION["location"] == "SA")) {echo "selected"; unset($_SESSION["location"]);}?>>Sibu Airport</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span>Pick-Up Date</span>
                        <input type="date" name="pud" id="pud" value='<?php if (!empty($_SESSION["pickupdate"])) {
                            echo $_SESSION["pickupdate"];
                            unset($_SESSION["pickupdate"]);}?>'>
                    </div>
                    <div class="input-box">
                        <span>Drop-Off Date</span>
                        <input type="date" name="dod" value='<?php if (!empty($_SESSION["dropoffdate"])) {
                            echo $_SESSION["dropoffdate"]; 
                            unset($_SESSION["dropoffdate"]);}?>'>
                    </div>

                    <input type="submit" value="Search Availability" class="search-button">
                </form>
            </div>
        </section>

        <hr>

        <!--Car Rental Guidelines-->
        <section class="guides" id="guides">
            <div class="heading">
                <p>Car Rental Guidelines</p>
                <h1>Rent with 3 Easy Steps</h1>
            </div>

            <div class="guides-container">
                <div class="box">
                    <i class='bx bx-map'></i>
                    <h2>Choose Your Location</h2>
                    <p>Choose your desired location to pick-up and return the rented car.</p>
                </div>

                <div class="box">
                    <i class='bx bxs-calendar'></i>
                    <h2>Choose a Date</h2>
                    <p>Choose the dates for picking up and returning the car.</p>
                </div>

                <div class="box">
                    <i class='bx bxs-car'></i>
                    <h2>Book a Car</h2>
                    <p>Select the car you desired for renting. Different types of cars are provided.</p>
                </div>
            </div>
        </section>

        <hr>

        <!--Services provided-->
        <section class="services" id="services">
            <div class="heading">
                <p>Best Services</p>
                <h1>Experience a Top Notch Service</h1>
            </div>

            <div class="services-container">
                <div class="box">
                    <i class='bx bx-shield-quarter'></i>
                    <h2>Insurance</h2>
                    <p> CarMe provides the best insurance policies that is benefial to our customers. 
                    </p>
                </div>

                <div class="box">
                    <i class='bx bxs-car-mechanic'></i>
                    <h2>Maintenance</h2>
                    <p>CarMe assures our customers with the most reliable and efficient maintenance services. 
                    </p>
                </div>

                <div class="box">
                    <i class='bx bx-money-withdraw'></i>
                    <h2>Road Tax</h2>
                    <p>CarMe provides current and valid road tax for every rented car.  
                    </p>
                </div>
            </div>
        </section>

        <hr>

        <!--Available Cars-->
        <section class="cars" id="cars">
            <div class="heading">
                <p>Available Cars</p>
                <h1>Various Types of Cars Provided</h1>
            </div>

            <div class="cars-container">
                <div class="box">
                    <div class='cars-img'>
                        <img src="images/perodua-Axia.png" alt="Perodua Axia">
                    </div>
                    <h2>Perodua Axia</h2>
                    <h3>Hatchback | 5 seaters</h3>
                    <p>RM99/day</p>
                </div>

                <div class="box">
                    <div class='cars-img'>
                        <img src="images/perodua-myvi.png" alt="Perodua Myvi">
                    </div>
                    <h2>Perodua Myvi</h2>
                    <h3>Hatchback | 5 seaters</h3>
                    <p>RM109/day</p>
                </div>

                <div class="box">
                    <div class='cars-img'>
                        <img src="images/proton-saga.png" alt="Proton Saga">
                    </div>
                    <h2>Proton Saga</h2>
                    <h3>Sedan | 5 seaters</h3>
                    <p>RM119/day</p>
                </div>

                <div class="box">
                    <div class='cars-img'>
                        <img src="images/perodua-bezza.png" alt="Perodua Bezza">
                    </div>
                    <h2>Perodua Bezza</h2>
                    <h3>Sedan | 5 seaters</h3>
                    <p>RM129/day</p>
                </div>

                <div class="box">
                    <div class='cars-img'>
                        <img src="images/ProtonX50.png" alt="Proton X50">
                    </div>
                    <h2>Proton X50</h2>
                    <h3>SUV | 5 seaters</h3>
                    <p>RM259/day</p>
                </div>

                <div class="box">
                    <div class='cars-img'>
                        <img src="images/perodua-aruz.png" alt="Perodua Aruz">
                    </div>
                    <h2>Perodua Aruz</h2>
                    <h3>SUV | 7 seaters</h3>
                    <p>RM309/day</p>
                </div>
            </div>
        </section>

        <hr>

        <!--About CarMe-->
        <section class="about" id="about">
            <div class="heading">
                <p>About Us</p>
                <h1>Every Mile with CarMe</h1>
            </div>
            <div class = "about-container">
                <div class="about-image">
                    <img src="images/CarMeLogoFull.png" alt="CarMe Logo">
                </div>
                <div class="about-text">
                    <p> CarMe is a car rental service business established in 2022.</p>
                    <p>With a simple goal of lessening people's burden in transportation, 4 young entrepreneurs sought to provide CarMe that is more than just a platform to take a person from point A to B.</p>
                </div>
            </div>
        </section>

        <!--Newsletter-->
        <section class="newsletter">
            <h2>Subscribe To Our Newsletter</h2>
            <div class="box">
                <form action="support/email_newsletter.php" method="post">
                    <input type = "text" name="nwsl-email" placeholder = "Enter Your E-mail..." class="enter-email" id="enter-email">
                    <input type="submit" value="Subscribe" class="subscribe-button" id="subscribe-button">
                </form>
            </div>
        </section>

        <!--Footer-->
        <footer>
            <div class = "copyright">
                <p> &#169 CarMe All Rights Reserved</p>
            </div>

            <div class ="support">
                <li><a href = "documents/CarMe_FAQ.pdf" target="_blank">FAQ</a><span> | </span></li>
                <li><a href = "documents/CarMe_TnC.pdf" target="_blank">Terms and Conditions</a><span> | </span></li>
                <li><a href="support/contact_us.php" class="a-cu" id="a-cu">Contact Us</a></li>
            </div>
        </footer>

        <!--Link to JavaScript-->
        <script type="text/javascript" src="javascript/main.js"></script>
    </body>

</html>