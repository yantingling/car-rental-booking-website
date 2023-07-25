<?php

session_start();

unset($_SESSION["adminID"]);
unset($_SESSION["admin_fullname"]);
unset($_SESSION["admin_username"]);
unset($_SESSION["admin_email"]);
unset($_SESSION["password"]);
unset($_SESSION["admin_password"]);

header("Location: ../index.php");
exit();

?>