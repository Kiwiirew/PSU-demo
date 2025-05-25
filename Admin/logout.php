<?php
session_start(); 

unset($_SESSION['admin_username']);
unset($_SESSION['admin_FullName']);


header("Location: index.php");
?>
