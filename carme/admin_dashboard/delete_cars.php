<?php
	include "../config_php/configuration.php";
	global $connection;
	$received_id = $_REQUEST['key_id'];

    $sqlretrieve = "SELECT * FROM cars WHERE carplate = '$received_id'";
    global $connection;

    $result = mysqli_query($connection, $sqlretrieve);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $carplate = $row["carplate"];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Yan, Natalie, Athira, Thanish">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CarMe Delete Car</title>

        <!--Link to CSS-->
        <link rel="stylesheet" href="../css/pages_of_forms.css">
    </head>

    <body>
        <div class="heading-text" id="heading-text">
            <h2>Delete Selected Car from the System:</h2>
        </div>

        <div class="dlt-form-container">
            <form action="validate_cars_delete.php?key_id=<?php echo $carplate?>" method="POST">

                <div class="dlt-input-box">
                    <span>Confirm deletion of Car (<?php echo $carplate; ?>)?</span>
                </div>

                <br>
                <br>
                
                <div class="buttons">
                    <a href="cars.php" class="dlt-cncl-button" id="dlt-cncl-button">Cancel</a>
                    <input type="submit" name="delete" value="Delete" class="dlt-button" id="dlt-button">
                </div>
                
            </form>
        </div>
    </body>
</html>