<?php

session_start();

unset($_SESSION["memberID"]);
unset($_SESSION["username"]);
unset($_SESSION["fullname"]);
unset($_SESSION["email"]);
unset($_SESSION["password"]);
unset($_SESSION["confirmpw"]);
unset($_SESSION["shopping_cart"]);

header("Location: ../index.php");
exit();

?>