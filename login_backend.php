<?php
require_once 'session_manager.php';
include 'Admin/db_conn.php';

// Initialize response
$response = ['success' => false, 'message' => ''];

// Check if the form fields 'email' and 'password' are set
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $response['message'] = 'Both email and password are required.';
        echo json_encode($response);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
        echo json_encode($response);
        exit();
    }

    try {
        // Use prepared statement to prevent SQL injection
        $query = "SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);
        
        if (!$stmt) {
            $response['message'] = 'Database error. Please try again later.';
            echo json_encode($response);
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // User found, check password
            $user = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful - use session manager
                $userData = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
                
                SessionManager::login($userData);
                SessionManager::setFlashMessage('Welcome back, ' . htmlspecialchars($user['name']) . '!', 'success');
                
                $response['success'] = true;
                $response['message'] = 'Login successful!';
                $response['redirect'] = 'index.php';
                
            } else {
                // Incorrect password
                $response['message'] = 'Incorrect password. Please try again.';
                
                // Optional: Log failed login attempt
                error_log("Failed login attempt for email: $email from IP: " . $_SERVER['REMOTE_ADDR']);
            }
        } else {
            // No account found
            $response['message'] = 'No account found with that email address.';
        }
        
        mysqli_stmt_close($stmt);
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        $response['message'] = 'An error occurred during login. Please try again.';
    }
    
} else {
    $response['message'] = 'Invalid request. Please try again.';
}

// Send JSON response for AJAX requests
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Fallback for non-AJAX requests
    if ($response['success']) {
        header('Location: index.php');
    } else {
        SessionManager::setFlashMessage($response['message'], 'error');
        header('Location: login.php');
    }
}
exit();
?>
