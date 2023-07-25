<?php
    session_start();
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
            <title>CarMe Edit Car</title>

            <!--Link to CSS-->
            <link rel="stylesheet" href="../css/pages_of_forms.css">
        </head>

        <body>
            <?php

                $sqlretrieve = "SELECT * FROM cars WHERE carplate = '$received_id'";
                global $connection;

                $result = mysqli_query($connection, $sqlretrieve);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $carplate = $row["carplate"];
                $type = $row["type"];
                $brand = $row["brand"];
                $model= $row["model"];
                $seater = $row["seater"];
                $price= $row["price"];
                $location= $row["location"];
            ?>

            <div class="heading-text" id="heading-text">
                <h2>Edit Car (<?php echo $carplate ?>) Information:</h2>
            </div>
                
            <div class="ec-form-container">
                <form action="validate_cars_edit.php?key_id=<?php echo $carplate;?>" method="POST">

                    <div class="ec-input-box">
                        <span>Type</span>
                        <br>
                        <input type="text" name="type" placeholder="Enter Car Type" id="type" value="<?php echo $type;?>">
                        <div class="regi-msg">
                            <p><?php
                                if(isset($_SESSION["typeErr"]))
                                {
                                    echo $_SESSION["typeErr"];
                                    unset($_SESSION["typeErr"]);
                                }
                            ?></p>
                        </div> 
                    </div>

                    <div class="ec-input-box">
                        <span>Car Brand</span>
                        <br>
                        <input type="text" name="brand" placeholder="Enter Car Brand" id="brand" value="<?php echo $brand;?>">
                        <div class="regi-msg">
                            <p><?php
                                if(isset($_SESSION["brandErr"]))
                                {
                                    echo $_SESSION["brandErr"];
                                    unset($_SESSION["brandErr"]);
                                }
                            ?></p>
                        </div> 
                    </div>

                    <div class="ec-input-box">
                        <span>Car Model</span>
                        <br>
                        <input type="text" name="model" placeholder="Enter Car Model" id="model" value="<?php echo $model;?>">
                        <div class="regi-msg">
                            <p><?php
                                if(isset($_SESSION["modelErr"]))
                                {
                                    echo $_SESSION["modelErr"];
                                    unset($_SESSION["modelErr"]);
                                }
                            ?></p>
                        </div> 
                    </div>

                    <div class="ec-input-box">
                        <span>Number of Seaters</span>
                        <br>
                        <input type="text" name="seater" placeholder="Enter Number of Seaters" id="seater" value="<?php echo $seater;?>">
                        <div class="regi-msg">
                            <p><?php
                                if(isset($_SESSION["seaterErr"]))
                                {
                                    echo $_SESSION["seaterErr"];
                                    unset($_SESSION["seaterErr"]);
                                }
                            ?></p>
                        </div> 
                    </div>

                    <div class="ec-input-box">
                        <span>Rental Price per Day (RM)</span>
                        <br>
                        <input type="text" name="price" placeholder="Enter Rental Price per Day" id="price" value="<?php echo $price;?>">
                        <div class="regi-msg">
                            <p><?php
                                if(isset($_SESSION["priceErr"]))
                                {
                                    echo $_SESSION["priceErr"];
                                    unset($_SESSION["priceErr"]);
                                }
                            ?></p>
                        </div> 
                    </div>

                    <div class="ec-input-box">
                        <span>Location</span>
                        <br>
                        <input type="text" name="location" placeholder="Enter Location" id="location" value="<?php echo $location;?>">
                    </div>
                    
                    <div class="buttons">
                        <a href="cars.php" class="ec-cncl-button" id="ec-cncl-button">Cancel</a>
                        <input type="submit" name="update" value="Update Car Information" class="ec-button" id="ec-button">
                    </div>
                </form>
            </div>
</body>
</html>