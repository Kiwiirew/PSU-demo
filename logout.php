<?php
require_once 'session_manager.php';

// Check if user is logged in
if (SessionManager::isLoggedIn()) {
    $userName = SessionManager::getCurrentUser()['name'] ?? 'User';
    
    // Logout user
    SessionManager::logout();
    
    // Set a farewell message
    session_start();
    SessionManager::setFlashMessage("Goodbye, $userName! You have been successfully logged out.", 'success');
} else {
    // User wasn't logged in
    session_start();
    SessionManager::setFlashMessage('You were not logged in.', 'info');
}

// Redirect to home page
header('Location: index.php');
exit();
?>
