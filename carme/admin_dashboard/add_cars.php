<?php
	include "../config_php/configuration.php";
	global $connection;
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Add New Car</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>
        <?php
            session_start();
            $carplate = $cartype = $carbrand = $carmodel= $seater= $price = $location = "";
            $carplateErr= $carTypeErr = $carBrandErr = $carModelErr = $seaterErr = $priceErr = $locationErr = "";
            $successMsg = $conErr = $manyErr = "";

            if($_SERVER["REQUEST_METHOD"] == "POST")
            {	
                $carplate = $_POST["carplate"];
                $cartype = $_POST["cartype"];
                $carbrand = $_POST["carbrand"];
                $carmodel = $_POST["carmodel"];
                $seater = (int)$_POST["seater"];
                $price = (float)$_POST["price"];
                $location = $_POST["location"];

                if (empty($carplate) && empty($cartype) && empty($carbrand) && empty($carmodel) && empty($seater) && empty($price) && empty($location))
                {
                    $manyErr = "Empty form, please fill all the information.";
                }
                elseif (empty($carplate))
                {
                    $carplateErr = "Car Plate is required, please re-enter.";
                }
                elseif (empty($cartype))
                {
                    $carTypeErr = "Car Type is required, please re-enter.";
                }
                elseif (empty($carbrand))
                {
                    $carBrandErr = "Car Brand is required, please re-enter.";
                }
                elseif (empty($carmodel))
                {
                    $carModelErr = "Car Model is required, please re-enter.";
                }
                elseif (empty($seater))
                {
                    $seaterErr = "Number of Seater is required, please re-enter.";
                }
                elseif (empty($price))
                {
                    $priceErr = "Rental Price per Day (RM) is required, please re-enter.";
                }
                elseif (empty($location))
                {
                    $locationErr = "Rental Location is required, please re-enter.";
                }
                //check if car plate is in correct format
                elseif(!preg_match("/^(?=.*?[A-Z])(?=.*?[0-9])\S{7,12}$/", $carplate))
                {
                    $carplateErr = "Car Plate should have minimum 7 characters and only start with uppercase letters followed by numbers.";
                }   
                 //check if car seater is only in number format
                elseif(!is_numeric($seater))
                {
                    $seaterErr = "Number of Seaters should be written in integers only.";
                }
                // check if rental price is only in number (decimal places accepted) format
                elseif(!is_numeric($price))
                {   
                    $priceErr = "Rental Price per Day (RM) should be in number format (may include decimal places).";
                }
                else
                {
                    $sqladd = "INSERT INTO cars (carplate, type, brand, model, seater, price, location) VALUES ('$carplate', '$cartype','$carbrand','$carmodel','$seater','$price', '$location')";
                    if(mysqli_query($connection, $sqladd))
                    {
                        $successMsg = "Successful Addition of New Car";
                        echo "<script>alert('$successMsg')</script>";
                        echo "<script type=\"text/javascript\">";
                        echo "window.location = \"cars.php\";";
                        echo "</script>";
                    }
                    else
                    {
                        $conErr = "Failed Addition of New Car.";
                        echo "<script>alert('$conErr')</script>";
                        echo "<script type=\"text/javascript\">";
                        echo "window.location = \"cars.php\";";
                        echo "</script>";
                    }
                }
            }
        ?>

        <div class="heading-text" id="heading-text">
            <h2>Create a New Car Entry:</h2>
        </div>
            
        <div class="nc-form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                <div class="nc-input-box">
                    <span>Car Plate</span>
                    <br>
                    <input type="text" name="carplate" placeholder="Enter Car Plate" id="carplate">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($carplateErr))
                            {
                                echo $carplateErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="nc-input-box">
                    <span>Type</span>
                    <br>
                    <input type="text" name="cartype" placeholder="Enter Car Type" id="cartype">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($carTypeErr))
                            {
                                echo $carTypeErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="nc-input-box">
                    <span>Car Brand</span>
                    <br>
                    <input type="text" name="carbrand" placeholder="Enter Car Brand" id="carbrand">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($carBrandErr))
                            {
                                echo $carBrandErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="nc-input-box">
                    <span>Car Model</span>
                    <br>
                    <input type="text" name="carmodel" placeholder="Enter Car Model" id="carmodel">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($carModelErr))
                            {
                                echo $carModelErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="nc-input-box">
                    <span>Number of Seaters</span>
                    <br>
                    <input type="text" name="seater" placeholder="Enter Number of Seaters" id="seater">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($seaterErr))
                            {
                                echo $seaterErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="nc-input-box">
                    <span>Rental Price per Day (RM)</span>
                    <br>
                    <input type="text" name="price" placeholder="Enter Rental Price per Day" id="price">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($priceErr))
                            {
                                echo $priceErr;
                            }
                        ?></p>
                    </div>
                </div>

                <div class="nc-input-box">
                    <span>Location</span>
                    <br>
                    <input type="text" name="location" placeholder="Enter Location" id="location">
                    <div class="regi-msg">
                        <p><?php
                            if(!empty($locationErr))
                            {
                                echo $locationErr;
                            }
                        ?></p>
                    </div>
                </div>
                
                <div class="buttons">
                    <a href="cars.php" class="nc-cncl-button" id="nc-cncl-button">Cancel</a>
                    <input type="submit" value="Add Car" class="nc-button" id="nc-button">
                </div>

                <div class="regi-msg">
                    <p><?php
                        if(!empty($manyErr))
                        {
                            echo $manyErr;
                        }
                    ?></p>
                </div>
            </form>
        </div>

    </body>
</html>