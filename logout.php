<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["withoutid"]);
unset($_SESSION["username"]);
session_destroy();
header("Location:homepage.php");
?>