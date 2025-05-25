<?php
session_start();
include("admin/db_conn.php");

// Function to create feedback table if it doesn't exist
function createFeedbackTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS feedback (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(500),
        message TEXT NOT NULL,
        rating INT DEFAULT 5,
        status ENUM('New', 'Reviewed', 'Resolved') DEFAULT 'New',
        admin_response TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_status (status),
        INDEX idx_rating (rating),
        INDEX idx_created_at (created_at)
    )";
    
    if (!$conn->query($sql)) {
        error_log("Error creating feedback table: " . $conn->error);
        return false;
    }
    return true;
}

// Create table if it doesn't exist
createFeedbackTable($conn);

// Function to validate input
function validateFeedbackInput($data) {
    $errors = [];
    
    if (empty(trim($data['name']))) {
        $errors[] = "Name is required";
    } elseif (strlen(trim($data['name'])) < 2) {
        $errors[] = "Name must be at least 2 characters long";
    }
    
    if (empty(trim($data['email']))) {
        $errors[] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    
    if (empty(trim($data['subject']))) {
        $errors[] = "Subject is required";
    } elseif (strlen(trim($data['subject'])) < 3) {
        $errors[] = "Subject must be at least 3 characters long";
    }
    
    if (empty(trim($data['message']))) {
        $errors[] = "Message is required";
    } elseif (strlen(trim($data['message'])) < 10) {
        $errors[] = "Message must be at least 10 characters long";
    }
    
    if (!isset($data['rating']) || !in_array($data['rating'], [1, 2, 3, 4, 5])) {
        $errors[] = "Please select a rating";
    }
    
    return $errors;
}

// Function to send notification email (optional)
function sendFeedbackNotification($feedbackData) {
    // You can implement email notification here if needed
    error_log("New feedback received from: " . $feedbackData['email'] . " - Rating: " . $feedbackData['rating']);
    return true;
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Sanitize and validate input
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);
        $rating = intval($_POST['rating']);
        
        // Validate input
        $validationErrors = validateFeedbackInput([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'rating' => $rating
        ]);
        
        if (!empty($validationErrors)) {
            echo "Error: " . implode(', ', $validationErrors);
            exit();
        }
        
        // Insert feedback into database using prepared statement
        $stmt = $conn->prepare("
            INSERT INTO feedback (
                name, email, subject, message, rating, status, created_at
            ) VALUES (?, ?, ?, ?, ?, 'New', NOW())
        ");
        
        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }
        
        $stmt->bind_param("ssssi", $name, $email, $subject, $message, $rating);
        
        if ($stmt->execute()) {
            $feedback_id = $conn->insert_id;
            
            // Log the feedback creation
            error_log("New feedback created: ID {$feedback_id}, Email: {$email}, Subject: {$subject}, Rating: {$rating}");
            
            // Send notification (optional)
            $feedbackData = [
                'id' => $feedback_id,
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'rating' => $rating
            ];
            sendFeedbackNotification($feedbackData);
            
            $stmt->close();
            
            echo "Feedback submitted successfully! Thank you for your valuable input.";
            
        } else {
            throw new Exception("Database execution error: " . $stmt->error);
        }
        
    } catch (Exception $e) {
        // Log the error
        error_log("Feedback submission error: " . $e->getMessage());
        echo "Error: Failed to submit feedback. Please try again later.";
    }
} else {
    echo "Error: Invalid request method.";
}

$conn->close();
?>
