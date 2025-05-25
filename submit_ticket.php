<?php
session_start();
include("admin/db_conn.php");
require_once 'session_check.php';

// Check if user is authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php?error=Please login to submit tickets");
    exit();
}

// Function to create tickets table if it doesn't exist
function createTicketsTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS tickets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(500) NOT NULL,
        description TEXT NOT NULL,
        priority ENUM('Low', 'Medium', 'High', 'Critical') DEFAULT 'Medium',
        department VARCHAR(255),
        status ENUM('Open', 'In Progress', 'Resolved', 'Closed') DEFAULT 'Open',
        attachments JSON,
        admin_response TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        resolved_at TIMESTAMP NULL,
        assigned_to INT,
        INDEX idx_user_email (email),
        INDEX idx_status (status),
        INDEX idx_priority (priority),
        INDEX idx_created_at (created_at)
    )";
    
    if (!$conn->query($sql)) {
        error_log("Error creating tickets table: " . $conn->error);
        return false;
    }
    return true;
}

// Create table if it doesn't exist
createTicketsTable($conn);

// Function to send notification email (optional - you can implement this later)
function sendTicketNotification($ticketData) {
    // You can implement email notification here
    // mail($adminEmail, "New Ticket Submitted", $message, $headers);
    return true;
}

// Function to validate and sanitize input
function validateInput($data) {
    $errors = [];
    
    if (empty(trim($data['subject']))) {
        $errors[] = "Subject is required";
    } elseif (strlen(trim($data['subject'])) < 5) {
        $errors[] = "Subject must be at least 5 characters long";
    }
    
    if (empty(trim($data['description']))) {
        $errors[] = "Description is required";
    } elseif (strlen(trim($data['description'])) < 20) {
        $errors[] = "Description must be at least 20 characters long";
    }
    
    if (!in_array($data['priority'], ['Low', 'Medium', 'High', 'Critical'])) {
        $errors[] = "Invalid priority level";
    }
    
    return $errors;
}

// Function to handle file uploads
function handleFileUploads($files) {
    $uploadedFiles = [];
    $errors = [];
    
    if (!isset($files['screenshots']) || empty($files['screenshots']['name'][0])) {
        return ['files' => $uploadedFiles, 'errors' => $errors];
    }
    
    // Create uploads directory if it doesn't exist
    $uploadDir = "uploads/tickets/";
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            $errors[] = "Failed to create upload directory";
            return ['files' => $uploadedFiles, 'errors' => $errors];
        }
    }
    
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    
    for ($i = 0; $i < count($files['screenshots']['name']); $i++) {
        if (empty($files['screenshots']['name'][$i])) continue;
        
        $fileName = $files['screenshots']['name'][$i];
        $fileSize = $files['screenshots']['size'][$i];
        $fileTmpName = $files['screenshots']['tmp_name'][$i];
        $fileError = $files['screenshots']['error'][$i];
        
        // Check for upload errors
        if ($fileError !== UPLOAD_ERR_OK) {
            $errors[] = "Upload error for file: " . $fileName;
            continue;
        }
        
        // Check file size
        if ($fileSize > $maxFileSize) {
            $errors[] = "File too large: " . $fileName . " (max 10MB)";
            continue;
        }
        
        // Check file type
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExt, $allowedTypes)) {
            $errors[] = "Invalid file type: " . $fileName;
            continue;
        }
        
        // Generate unique filename
        $uniqueName = uniqid() . '_' . time() . '.' . $fileExt;
        $targetPath = $uploadDir . $uniqueName;
        
        // Move uploaded file
        if (move_uploaded_file($fileTmpName, $targetPath)) {
            $uploadedFiles[] = [
                'original_name' => $fileName,
                'stored_name' => $uniqueName,
                'file_path' => $targetPath,
                'file_size' => $fileSize,
                'file_type' => $fileExt,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];
        } else {
            $errors[] = "Failed to upload file: " . $fileName;
        }
    }
    
    return ['files' => $uploadedFiles, 'errors' => $errors];
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get user information from session
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'] ?? 'User';
        $user_email = $_SESSION['user_email'];
        
        // Sanitize and validate input
        $subject = trim($_POST['subject']);
        $description = trim($_POST['description']);
        $priority = $_POST['priority'] ?? 'Medium';
        $department = $_POST['department'] ?? '';
        
        // Validate input
        $validationErrors = validateInput([
            'subject' => $subject,
            'description' => $description,
            'priority' => $priority
        ]);
        
        if (!empty($validationErrors)) {
            $errorMessage = implode(', ', $validationErrors);
            header("Location: unified_ticket_support.php?error=" . urlencode($errorMessage));
            exit();
        }
        
        // Handle file uploads
        $uploadResult = handleFileUploads($_FILES);
        $attachments = $uploadResult['files'];
        $uploadErrors = $uploadResult['errors'];
        
        // Insert ticket into database
        $attachmentsJson = !empty($attachments) ? json_encode($attachments) : null;
        
        $stmt = $conn->prepare("
            INSERT INTO tickets (
                user_id, name, email, subject, description, priority, 
                department, status, attachments, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'Open', ?, NOW())
        ");
        
        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }
        
        $stmt->bind_param("isssssss", 
            $user_id, $user_name, $user_email, $subject, 
            $description, $priority, $department, $attachmentsJson
        );
        
        if ($stmt->execute()) {
            $ticket_id = $conn->insert_id;
            
            // Log the ticket creation
            error_log("New ticket created: ID {$ticket_id}, User: {$user_email}, Subject: {$subject}");
            
            // Send notification (optional)
            $ticketData = [
                'id' => $ticket_id,
                'user_name' => $user_name,
                'user_email' => $user_email,
                'subject' => $subject,
                'description' => $description,
                'priority' => $priority,
                'department' => $department
            ];
            sendTicketNotification($ticketData);
            
            $stmt->close();
            
            // Prepare success message
            $successMessage = "Your ticket has been submitted successfully! Ticket ID: #" . $ticket_id;
            if (!empty($uploadErrors)) {
                $successMessage .= " Note: Some files couldn't be uploaded: " . implode(', ', $uploadErrors);
            }
            
            header("Location: unified_ticket_support.php?success=" . urlencode($successMessage));
            exit();
            
        } else {
            throw new Exception("Database execution error: " . $stmt->error);
        }
        
    } catch (Exception $e) {
        // Log the error
        error_log("Ticket submission error: " . $e->getMessage());
        
        // Clean up any uploaded files if database insert failed
        if (isset($attachments) && !empty($attachments)) {
            foreach ($attachments as $file) {
                if (file_exists($file['file_path'])) {
                    unlink($file['file_path']);
                }
            }
        }
        
        header("Location: unified_ticket_support.php?error=" . urlencode("Failed to submit ticket. Please try again."));
        exit();
    }
} else {
    // If not POST request, redirect back
    header("Location: unified_ticket_support.php");
    exit();
}

$conn->close();
?>

