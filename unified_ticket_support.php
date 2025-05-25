<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="assets/css/styles1.css">

<?php 
include('head.php'); 
require_once 'session_manager.php';
include('admin/db_conn.php');

// Require login to access this page
SessionManager::requireLogin('login.php');

// Get current user info
$currentUser = SessionManager::getCurrentUser();
$flashMessage = SessionManager::getFlashMessage();

// Initialize debug information
$debug_info = [
    'session_email' => $_SESSION['user_email'] ?? 'NOT SET',
    'session_id' => $_SESSION['user_id'] ?? 'NOT SET',
    'user_tickets_count' => 0,
    'database_error' => '',
    'table_exists' => false
];

// Get user tickets if logged in with enhanced error handling
$user_tickets = [];

if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
    
    // First check if tickets table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'tickets'");
    $debug_info['table_exists'] = ($table_check && $table_check->num_rows > 0);
    
    if ($debug_info['table_exists']) {
        // Check table structure
        $structure_check = $conn->query("SHOW COLUMNS FROM tickets LIKE 'subject'");
        $has_subject_column = ($structure_check && $structure_check->num_rows > 0);
        
        if (!$has_subject_column) {
            // Add missing subject column if it doesn't exist
            $conn->query("ALTER TABLE tickets ADD COLUMN subject VARCHAR(500) NOT NULL DEFAULT 'Support Request' AFTER email");
        }
        
        // Now try to get user tickets
        $sql = "SELECT * FROM tickets WHERE email = ? ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result) {
                $user_tickets = $result->fetch_all(MYSQLI_ASSOC);
                $debug_info['user_tickets_count'] = count($user_tickets);
            } else {
                $debug_info['database_error'] = "Query result failed: " . $conn->error;
            }
            
            $stmt->close();
        } else {
            $debug_info['database_error'] = "Statement prepare failed: " . $conn->error;
        }
    } else {
        // Create tickets table if it doesn't exist
        $create_table_sql = "CREATE TABLE IF NOT EXISTS tickets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            name VARCHAR(255) NOT NULL DEFAULT '',
            email VARCHAR(255) NOT NULL DEFAULT '',
            subject VARCHAR(500) NOT NULL DEFAULT 'Support Request',
            description TEXT NOT NULL,
            priority ENUM('Low', 'Medium', 'High', 'Critical') DEFAULT 'Medium',
            department VARCHAR(255) DEFAULT '',
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
        
        if ($conn->query($create_table_sql)) {
            $debug_info['table_exists'] = true;
            $debug_info['database_error'] = "Table created successfully";
        } else {
            $debug_info['database_error'] = "Failed to create table: " . $conn->error;
        }
    }
} else {
    $debug_info['database_error'] = "No user email in session";
}
?>

<body>
    <!-- Loading Animation -->
    <div class="loading-container">
        <!-- Content will be dynamically added by JavaScript -->
    </div>

    <div class="main-wrapper">
        
        <?php include('dynamic_header.php'); ?>
        <?php include('dynamic_mobile_header.php'); ?>

        <div class="overlay"></div>

        <!-- Flash Message Display -->
        <?php if ($flashMessage): ?>
            <div class="flash-message-container">
                <div class="container">
                    <div class="alert alert-<?php echo $flashMessage['type'] === 'error' ? 'danger' : $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($flashMessage['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Enhanced Hero Section -->
        <div class="hero-parallax" style="background-image: url('assets/images/landingpage.jpg'); height: 40vh;" data-speed="0.5">
            <div class="hero-content">
                <h1 class="hero-title" style="font-size: 2.5rem;">
                    <i class="fas fa-headset"></i> IT Support Center
                </h1>
                <p class="hero-subtitle">Submit tickets, track progress, and get technical assistance</p>
            </div>
        </div>

        <!-- Unified Ticket Support Dashboard -->
        <div class="ticket-dashboard">
            <div class="container">
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <h1><i class="fas fa-ticket-alt"></i> Support Ticket System</h1>
                    <p>Submit your technical issues and track their progress</p>
                    <div class="user-welcome-section">
                        <div class="user-info">
                            <h3>Welcome, <?php echo htmlspecialchars($currentUser['name']); ?>! 👋</h3>
                            <p>We're here to help you with any technical issues. Please provide detailed information so our team can assist you effectively.</p>
                        </div>
                    </div>
                </div>

                <!-- Ticket Tabs -->
                <div class="ticket-tabs">
                    <button class="tab-btn active" onclick="switchTab('submit')">
                        <i class="fas fa-plus-circle"></i>
                        Submit New Ticket
                    </button>
                    <button class="tab-btn" onclick="switchTab('history')">
                        <i class="fas fa-history"></i>
                        My Tickets (<?php echo count($user_tickets); ?>)
                    </button>
                </div>

                <!-- Submit Ticket Tab -->
                <div id="submit-tab" class="tab-content active">
                    <div class="form-container-modern">
                        <h2 style="text-align: center; margin-bottom: 30px; color: var(--psu-blue);">
                            <i class="fas fa-paper-plane"></i> Submit Support Ticket
                        </h2>
                        
                        <form action="submit_ticket.php" method="POST" enctype="multipart/form-data" id="ticketForm">
                            <!-- CSRF Token -->
                            <input type="hidden" name="csrf_token" value="<?php echo SessionManager::generateCSRFToken(); ?>">
                            
                            <!-- Auto-fill user info from session -->
                            <input type="hidden" name="user_id" value="<?php echo $currentUser['id']; ?>">

                            <!-- Name Fields (Pre-filled) -->
                            <div class="form-group">
                                <label for="full-name"><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" id="full-name" name="full_name" value="<?php echo htmlspecialchars($currentUser['name']); ?>" readonly class="readonly-field">
                            </div>

                            <!-- Email Field (Pre-filled) -->
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" readonly class="readonly-field">
                            </div>

                            <!-- Subject Field -->
                            <div class="form-group">
                                <label for="subject"><i class="fas fa-heading"></i> Subject *</label>
                                <input type="text" id="subject" name="subject" class="form-control" required 
                                       placeholder="Brief description of your issue">
                            </div>

                            <!-- Department Field -->
                            <div class="form-group">
                                <label for="department"><i class="fas fa-building"></i> Department/Program</label>
                                <select id="department" name="department" required>
                                    <option value="">Select your Department/Program</option>
                                    <option value="BSIT">Bachelor of Science in Information Technology</option>
                                    <option value="BSBA">Bachelor of Science in Business Administration</option>
                                    <option value="BTLE">Bachelor of Technology and Livelihood Education</option>
                                    <option value="BEE">Bachelor of Elementary Education</option>
                                    <option value="BIT">Bachelor of Industrial Technology</option>
                                    <option value="BSE">Bachelor of Secondary Education</option>
                                    <option value="Faculty">Faculty Member</option>
                                    <option value="Staff">Staff Member</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Priority Level -->
                            <div class="form-group">
                                <label for="priority"><i class="fas fa-flag"></i> Priority Level</label>
                                <select id="priority" name="priority" required>
                                    <option value="">Select Priority Level</option>
                                    <option value="Low">Low - General inquiry or minor issue</option>
                                    <option value="Medium" selected>Medium - Affecting work but workaround available</option>
                                    <option value="High">High - Significantly impacting work</option>
                                    <option value="Critical">Critical - System down or urgent issue</option>
                                </select>
                            </div>

                            <!-- Issue Category -->
                            <div class="form-group">
                                <label for="category"><i class="fas fa-tag"></i> Issue Category</label>
                                <select id="category" name="category" required>
                                    <option value="">Select Issue Category</option>
                                    <option value="Virtual Tour">Virtual Tour Access/Navigation</option>
                                    <option value="Website">Website Functionality</option>
                                    <option value="Login">Login/Account Issues</option>
                                    <option value="Course Information">Course Information</option>
                                    <option value="Technical Support">General Technical Support</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Problem Description -->
                            <div class="form-group">
                                <label for="description"><i class="fas fa-comment-alt"></i> Describe the Problem *</label>
                                <textarea id="description" name="description" placeholder="Please provide detailed information about the issue you're experiencing..." required rows="6"></textarea>
                                <small class="form-text">Include steps to reproduce the issue, error messages, and any other relevant details.</small>
                            </div>

                            <!-- File Upload Field -->
                            <div class="form-group">
                                <label for="screenshot"><i class="fas fa-paperclip"></i> Upload Screenshots/Documents (Optional)</label>
                                <div class="file-upload-modern" onclick="document.getElementById('screenshot').click()">
                                    <input type="file" id="screenshot" name="screenshot[]" multiple style="display: none;" accept="image/*,.pdf,.doc,.docx">
                                    <div class="upload-content">
                                        <i class="icofont-upload-alt"></i>
                                        <p>Click here to upload files</p>
                                        <small>Supported formats: JPG, PNG, GIF, PDF, DOC (Max 5MB each)</small>
                                    </div>
                                </div>
                                <div id="image-preview" class="image-preview-container"></div>
                            </div>

                            <!-- Hidden Status Field -->
                            <input type="hidden" id="status" name="status" value="1">

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn-modern btn-primary-modern w-100" id="submitBtn">
                                    <i class="icofont-paper-plane"></i> Submit Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- My Tickets Tab -->
                <div id="history-tab" class="tab-content">
                    <h2 style="text-align: center; margin-bottom: 30px; color: var(--psu-blue);">
                        <i class="fas fa-history"></i> My Support Tickets
                    </h2>
                    
                    <div class="tickets-grid">
                        <?php if (empty($user_tickets)): ?>
                            <div class="empty-state">
                                <i class="fas fa-ticket-alt"></i>
                                <h3>No Tickets Found</h3>
                                <p>You haven't submitted any support tickets yet.</p>
                                
                                <!-- Debug Information -->
                                <div style="background: #f8f9fa; border-radius: 8px; padding: 15px; margin: 20px 0; text-align: left; font-size: 12px; color: #6c757d;">
                                    <strong>🔍 Debug Information:</strong><br>
                                    <strong>Email:</strong> <?php echo $debug_info['session_email']; ?><br>
                                    <strong>User ID:</strong> <?php echo $debug_info['session_id']; ?><br>
                                    <strong>Table Exists:</strong> <?php echo $debug_info['table_exists'] ? 'Yes' : 'No'; ?><br>
                                    <strong>Tickets Found:</strong> <?php echo $debug_info['user_tickets_count']; ?><br>
                                    <?php if (!empty($debug_info['database_error'])): ?>
                                        <strong>Database Status:</strong> <?php echo $debug_info['database_error']; ?><br>
                                    <?php endif; ?>
                                </div>
                                
                                <button onclick="switchTab('submit')" class="submit-btn" style="width: auto; padding: 12px 30px; margin-top: 20px;">
                                    Submit Your First Ticket
                                </button>
                            </div>
                        <?php else: ?>
                            <?php foreach ($user_tickets as $ticket): ?>
                                <div class="ticket-card clickable-ticket" onclick="viewTicket(<?php echo $ticket['id']; ?>)" title="Click to view details">
                                    <div class="ticket-header">
                                        <span class="ticket-id">#<?php echo $ticket['id']; ?></span>
                                        <span class="ticket-status status-<?php echo strtolower(str_replace(' ', '-', $ticket['status'])); ?>">
                                            <?php echo htmlspecialchars($ticket['status']); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="ticket-subject">
                                        <?php echo htmlspecialchars($ticket['subject'] ?? 'Support Request'); ?>
                                    </div>
                                    
                                    <div class="ticket-description">
                                        <?php echo htmlspecialchars(substr($ticket['description'], 0, 150) . '...'); ?>
                                    </div>
                                    
                                    <!-- Admin Response Preview -->
                                    <?php if (!empty($ticket['admin_response'])): ?>
                                        <div class="admin-response-preview">
                                            <div class="response-label">
                                                <i class="fas fa-reply"></i>
                                                Admin Response:
                                            </div>
                                            <div class="response-text">
                                                <?php echo htmlspecialchars(substr($ticket['admin_response'], 0, 100) . '...'); ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-response-indicator">
                                            <i class="fas fa-clock"></i>
                                            Awaiting admin response
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="ticket-meta">
                                        <div>
                                            <span class="priority-badge priority-<?php echo strtolower($ticket['priority'] ?? 'medium'); ?>">
                                                <?php echo htmlspecialchars($ticket['priority'] ?? 'Medium'); ?>
                                            </span>
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar"></i>
                                            <?php echo date('M d, Y', strtotime($ticket['created_at'])); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include('footer.php'); ?>

        <!-- Back to Top Button -->
        <a href="#" class="back-to-top floating">
            <i class="icofont-simple-up"></i>
        </a>
    </div>

    <?php include('scripts.php'); ?>

    <!-- Enhanced Unified Styles -->
    <style>
        :root {
            --psu-blue: #0A27D8;
            --psu-yellow: #FFE047;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
        }

        .ticket-dashboard {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 40px 0;
            margin-top: -50px;
            position: relative;
            z-index: 2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .dashboard-header h1 {
            color: var(--psu-blue);
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .dashboard-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .user-welcome-section {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }

        .user-welcome-section h3 {
            color: #0A27D8;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .user-welcome-section p {
            color: #666;
            margin: 0;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .ticket-tabs {
            display: flex;
            background: white;
            border-radius: 10px;
            padding: 5px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .tab-btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .tab-btn.active {
            background: var(--psu-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(10, 39, 216, 0.3);
        }

        .tab-btn:not(.active):hover {
            background: #f8f9fa;
            transform: translateY(-1px);
        }

        .tab-content {
            display: none;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .tab-content.active {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-container-modern {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #0A27D8;
            background: white;
            box-shadow: 0 0 0 3px rgba(10, 39, 216, 0.1);
        }

        .readonly-field {
            background: #e9ecef !important;
            color: #6c757d;
            cursor: not-allowed;
        }

        .file-upload-modern {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .file-upload-modern:hover {
            border-color: #0A27D8;
            background: rgba(10, 39, 216, 0.05);
        }

        .upload-content i {
            font-size: 3rem;
            color: #0A27D8;
            margin-bottom: 15px;
        }

        .upload-content p {
            color: #333;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .upload-content small {
            color: #666;
        }

        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .preview-item {
            position: relative;
            background: white;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            min-width: 150px;
        }

        .preview-image {
            position: relative;
        }

        .preview-image img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-info {
            margin-top: 10px;
            text-align: center;
        }

        .file-name {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .file-size {
            font-size: 0.8rem;
            color: #666;
        }

        .file-error {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .form-text {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .tickets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 20px;
        }

        .ticket-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .clickable-ticket {
            position: relative;
        }

        .clickable-ticket::after {
            content: "Click to view details";
            position: absolute;
            top: 10px;
            right: 15px;
            background: rgba(10, 39, 216, 0.1);
            color: var(--psu-blue);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .clickable-ticket:hover::after {
            opacity: 1;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .ticket-id {
            background: var(--psu-blue);
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .ticket-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-open { background: #fff3cd; color: #856404; }
        .status-in-progress { background: #d1ecf1; color: #0c5460; }
        .status-resolved { background: #d4edda; color: #155724; }
        .status-closed { background: #f8d7da; color: #721c24; }

        .ticket-subject {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .ticket-description {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .admin-response-preview {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 12px 15px;
            margin: 15px 0;
            border-radius: 0 8px 8px 0;
        }

        .response-label {
            font-weight: 600;
            color: #1976d2;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .response-text {
            color: #424242;
            font-size: 14px;
            line-height: 1.5;
        }

        .no-response-indicator {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 12px 15px;
            margin: 15px 0;
            border-radius: 0 8px 8px 0;
            color: #f57c00;
            font-size: 14px;
            font-weight: 500;
        }

        .ticket-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: var(--text-muted);
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .priority-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority-low { background: #e2e8f0; color: #475569; }
        .priority-medium { background: #fef3c7; color: #92400e; }
        .priority-high { background: #fed7d7; color: #c53030; }
        .priority-critical { background: #fbb6ce; color: #97266d; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .submit-btn, .btn-modern {
            background: linear-gradient(45deg, var(--psu-blue), #1e3a8a);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .submit-btn:hover, .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(10, 39, 216, 0.3);
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            transform: translateX(400px);
            transition: all 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success { background: var(--success-color); }
        .notification.error { background: var(--danger-color); }
        .notification.info { background: var(--info-color); }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            .dashboard-header h1 {
                font-size: 2rem;
            }
            
            .ticket-tabs {
                flex-direction: column;
                gap: 5px;
            }
            
            .tab-content {
                padding: 20px;
            }
            
            .tickets-grid {
                grid-template-columns: 1fr;
            }
            
            .form-container-modern {
                padding: 20px;
            }
        }
    </style>

    <script>
        // Enhanced JavaScript functionality
        
        // Tab switching functionality
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // File upload functionality with enhanced preview
        const screenshotInput = document.getElementById('screenshot');
        const imagePreview = document.getElementById('image-preview');
        const maxFileSize = 5 * 1024 * 1024; // 5MB max file size

        screenshotInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';

            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    if (file.size > maxFileSize) {
                        showFileError(`File too large: ${file.name} (Max 5MB)`);
                        return;
                    }

                    if (file.type.startsWith('image/') || file.type === 'application/pdf' || 
                        file.type.includes('document') || file.type.includes('word')) {
                        createFilePreview(file, index);
                    } else {
                        showFileError(`Invalid file type: ${file.name}`);
                    }
                });
            }
        });

        function createFilePreview(file, index) {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewItem.innerHTML = `
                        <div class="preview-image">
                            <img src="${e.target.result}" alt="Screenshot Preview">
                            <button type="button" class="remove-image" onclick="removeImage(this)">
                                <i class="icofont-close"></i>
                            </button>
                        </div>
                        <div class="preview-info">
                            <span class="file-name">${file.name}</span>
                            <span class="file-size">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        </div>
                    `;
                    imagePreview.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            } else {
                // For non-image files
                previewItem.innerHTML = `
                    <div class="preview-image">
                        <div style="height: 100px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 5px;">
                            <i class="fas fa-file fa-3x" style="color: var(--psu-blue);"></i>
                        </div>
                        <button type="button" class="remove-image" onclick="removeImage(this)">
                            <i class="icofont-close"></i>
                        </button>
                    </div>
                    <div class="preview-info">
                        <span class="file-name">${file.name}</span>
                        <span class="file-size">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                    </div>
                `;
                imagePreview.appendChild(previewItem);
            }
        }

        function removeImage(button) {
            button.closest('.preview-item').remove();
            // Update file input to remove the file (this is tricky with input[type=file])
            // For now, we'll let the server handle this
        }

        function showFileError(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'file-error';
            errorDiv.textContent = message;
            imagePreview.appendChild(errorDiv);

            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }

        // Form submission with loading state
        document.getElementById('ticketForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<div class="loading-spinner"></div> Submitting...';
            submitBtn.disabled = true;

            // Re-enable button after a delay in case of form validation errors
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
                ${message}
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; margin-left: 10px; cursor: pointer;">×</button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => notification.classList.add('show'), 100);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Function to view individual ticket
        function viewTicket(ticketId) {
            window.location.href = 'user_ticket_view.php?id=' + ticketId;
        }

        // Auto-refresh ticket status every 30 seconds when on history tab
        let refreshInterval;
        
        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                if (document.getElementById('history-tab').classList.contains('active')) {
                    // Only refresh the tickets section, not the whole page
                    location.reload();
                }
            }, 30000);
        }
        
        function stopAutoRefresh() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            startAutoRefresh();
            
            // Show success/error messages from URL parameters
            <?php if (isset($_GET['success'])): ?>
                showNotification('Your ticket has been submitted successfully! We will review it shortly.', 'success');
                // Switch to My Tickets tab to show the new ticket
                setTimeout(() => switchTab('history'), 2000);
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                showNotification('<?php echo addslashes($_GET['error']); ?>', 'error');
            <?php endif; ?>
        });
        
        // Stop auto-refresh when page is hidden
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoRefresh();
            } else {
                startAutoRefresh();
            }
        });
    </script>
</body>

</html> 