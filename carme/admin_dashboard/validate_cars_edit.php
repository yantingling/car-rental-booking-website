<?php

session_start();
include "../config_php/configuration.php";
global $connection;
$carplate = $_REQUEST['key_id'];

if(isset($_POST['update']))
{
    $type=$brand=$model=$seater=$price=$location= "";
    $typeErr = $brandErr = $modelErr = $seaterErr=$priceErr= $locationErr= "";

    $type = $_POST['type'];
    $brand= $_POST['brand'];
    $model = $_POST['model'];
    $seater= $_POST['seater'];
    $price=$_POST['price'];
    $location= $_POST['location'];

    
    if (empty($type))
    {
        $typeErr = "Car Type is required, re-enter please";
        $_SESSION["typeErr"] = $typeErr;
        header("Location: edit_cars.php");
        exit();
    }
    elseif (empty($brand))
    {
        $brandErr = "Brand is required, re-enter please";
        $_SESSION["brandErr"] = $brandErr;
        header("Location: edit_cars.php");
        exit();
    }
    elseif (empty($model)) 
    {   
        $modelErr = "Model is required, please re-enter,";
        $_SESSION["modelErr"] = $modelErr;
        header("Location: edit_cars.php");
        exit();

    }
    elseif(empty($seater))
    {   
        $seaterErr = "Please input the number of seats.";
        $_SESSION["seaterErr"] = $seaterErr;
        header("Location: edit_cars.php");
        exit();
    }
    elseif(!is_numeric($seater))
    {   
        $seaterErr = "Seater should be a number only.";
        $_SESSION["seaterErr"] = $seaterErr;
        header("Location: edit_cars.php");
        exit();
    }
    elseif(empty($location))
    {
        $locationErr = "Location is required.";
        $_SESSION["locationErr"] = $locationErr;
        header("Location: edit_cars.php");
        exit();
    }
    elseif(empty($price))
    {
        $priceErr = "Price per day is required.";
        $_SESSION["priceErr"] = $priceErr;
        header("Location: edit_cars.php");
        exit();
    }
    elseif(!is_numeric($price))
    {
        $priceErr = "Price should be in decimal or number format.";
        $_SESSION["priceErr"] = $priceErr;
        header("Location: edit_cars.php");
        exit();
    }
    else
    {
        $sqlupdate = "UPDATE cars SET type = '$type', brand = '$brand', model = '$model', seater = '$seater',price='$price', location='$location' WHERE carplate = '$carplate'";
        if(mysqli_query($connection, $sqlupdate))
        {
            //echo "Successfull";
            $successMsg = "Successful Update for the Car ".$carplate;
            echo "<script>alert('$successMsg')</script>";
            echo "<script type=\"text/javascript\">";
            echo "window.location = \"cars.php\";";
            echo "</script>";
        }else
        {
            $conErr = "Failed to update the Car " .$carplate;
            echo "<script>alert('$conErr')</script>";
            echo "<script type=\"text/javascript\">";
            echo "window.location = \"cars.php\";";
            echo "</script>";
        }
    }
}
mysqli_close($connection);
?>