<?php

session_start();
include "../config_php/configuration.php";
global $connection;

$carplate = $_REQUEST['key_id'];

if(isset($_POST['delete']))
{
    $sql = "DELETE FROM cars WHERE carplate = '$carplate'";

    if(mysqli_query($connection,$sql))
    {
        $successMsg="Car with carplate number ".$carplate. " was deleted successfully!";
        echo "<script>alert('$successMsg')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"cars.php\";";
        echo "</script>";

    }else{
        $conErr = "Failed to delete car with carplate number " .$carplate;
        echo "<script>alert('$conErr')</script>";
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"cars.php\";";
        echo "</script>";
    }
}
mysqli_close($connection);

?>