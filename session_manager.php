<?php
/**
 * PSU Virtual Tour System - Session Manager
 * Comprehensive session management for authentication and user states
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class SessionManager {
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Get current user data
     */
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'] ?? '',
                'email' => $_SESSION['user_email'] ?? ''
            ];
        }
        return null;
    }
    
    /**
     * Login user with credentials
     */
    public static function login($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['login_time'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        return true;
    }
    
    /**
     * Logout user and destroy session
     */
    public static function logout() {
        // Clear all session variables
        $_SESSION = array();
        
        // Delete the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        
        // Destroy the session
        session_destroy();
        return true;
    }
    
    /**
     * Require login - redirect to login page if not authenticated
     */
    public static function requireLogin($redirectTo = 'login.php') {
        if (!self::isLoggedIn()) {
            header("Location: $redirectTo");
            exit();
        }
    }
    
    /**
     * Redirect if already logged in
     */
    public static function redirectIfLoggedIn($redirectTo = 'index.php') {
        if (self::isLoggedIn()) {
            header("Location: $redirectTo");
            exit();
        }
    }
    
    /**
     * Get user greeting message
     */
    public static function getUserGreeting() {
        $user = self::getCurrentUser();
        if ($user) {
            $timeOfDay = date('H') < 12 ? 'Good morning' : (date('H') < 18 ? 'Good afternoon' : 'Good evening');
            return "$timeOfDay, " . htmlspecialchars($user['name']) . "!";
        }
        return "Welcome to PSU Virtual Tour!";
    }
    
    /**
     * Check session expiry (optional - for enhanced security)
     */
    public static function checkSessionExpiry($timeoutMinutes = 120) {
        if (self::isLoggedIn()) {
            $loginTime = $_SESSION['login_time'] ?? time();
            if ((time() - $loginTime) > ($timeoutMinutes * 60)) {
                self::logout();
                return false;
            }
            // Update last activity time
            $_SESSION['last_activity'] = time();
        }
        return true;
    }
    
    /**
     * Get navigation menu based on login status
     */
    public static function getNavigationMenu() {
        $baseMenu = [
            ['url' => 'index.php', 'title' => 'Home'],
            ['url' => 'courses.php', 'title' => 'Courses'],
            ['url' => 'Vtour/index.htm', 'title' => 'Virtual Tour'],
            ['url' => 'contact.php', 'title' => 'Contact']
        ];
        
        if (self::isLoggedIn()) {
            $baseMenu[] = ['url' => 'unified_ticket_support.php', 'title' => 'Ticket Support'];
            return $baseMenu;
        }
        
        return $baseMenu;
    }
    
    /**
     * Get authentication buttons for header
     */
    public static function getAuthButtons() {
        if (self::isLoggedIn()) {
            $user = self::getCurrentUser();
            return [
                'type' => 'logged_in',
                'user_name' => $user['name'],
                'logout_url' => 'logout.php'
            ];
        } else {
            return [
                'type' => 'guest',
                'login_url' => 'login.php',
                'register_url' => 'register.php'
            ];
        }
    }
    
    /**
     * Set flash message
     */
    public static function setFlashMessage($message, $type = 'info') {
        $_SESSION['flash_message'] = [
            'message' => $message,
            'type' => $type
        ];
    }
    
    /**
     * Get and clear flash message
     */
    public static function getFlashMessage() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}

/**
 * Helper functions for backward compatibility
 */
function isLoggedIn() {
    return SessionManager::isLoggedIn();
}

function getCurrentUser() {
    return SessionManager::getCurrentUser();
}

function requireLogin($redirectTo = 'login.php') {
    return SessionManager::requireLogin($redirectTo);
}

function getUserGreeting() {
    return SessionManager::getUserGreeting();
}
?> 