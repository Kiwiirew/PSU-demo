<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {
    header("Location: unified_ticket_support.php"); // Redirect authenticated users to the main user page
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
