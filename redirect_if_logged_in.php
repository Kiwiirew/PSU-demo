<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirectIfLoggedIn($redirectPage = 'unified_ticket_support.php') {
    if (isset($_SESSION['user_id'])) {
        header("Location: $redirectPage");
        exit;
    }
}
?>
