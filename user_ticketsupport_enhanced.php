<!DOCTYPE html>
<html lang="en">
 
<link rel="stylesheet" href="assets/css/styles1.css">
<!-- Head Section -->
<?php include('head.php'); 
       require_once 'session_check.php';
       authMiddleware();
       include('admin/db_conn.php');
       
       // Debug information
       $debug_info = [];
       $debug_info['session_email'] = $_SESSION['user_email'] ?? 'Not set';
       $debug_info['session_id'] = $_SESSION['user_id'] ?? 'Not set';
       $debug_info['session_name'] = $_SESSION['user_name'] ?? 'Not set';
       
       // Get user tickets with enhanced query
       $user_tickets = [];
       $tickets_debug = '';
       
       if (isset($_SESSION['user_email'])) {
           $email = $_SESSION['user_email'];
           
           // Enhanced query with better error handling
           $sql = "SELECT * FROM tickets WHERE email = ? ORDER BY created_at DESC";
           $stmt = $conn->prepare($sql);
           
           if ($stmt) {
               $stmt->bind_param("s", $email);
               $stmt->execute();
               $result = $stmt->get_result();
               
               if ($result) {
                   $user_tickets = $result->fetch_all(MYSQLI_ASSOC);
                   $tickets_debug = "Found " . count($user_tickets) . " tickets for email: " . $email;
               } else {
                   $tickets_debug = "Query executed but no result: " . $conn->error;
               }
               
               $stmt->close();
           } else {
               $tickets_debug = "Failed to prepare statement: " . $conn->error;
           }
       } else {
           $tickets_debug = "No user email in session";
       }
       
       // Get total ticket count for debugging
       $total_tickets = 0;
       $total_result = $conn->query("SELECT COUNT(*) as count FROM tickets");
       if ($total_result) {
           $total_tickets = $total_result->fetch_assoc()['count'];
       }
?>

<!-- Modern Ticket Support Styles -->
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
    margin: 0;
}

.debug-panel {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    font-size: 12px;
    color: #6c757d;
}

.debug-panel.hidden {
    display: none;
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

.ticket-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-dark);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: var(--psu-blue);
    box-shadow: 0 0 0 3px rgba(10, 39, 216, 0.1);
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.priority-select {
    background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") no-repeat right 8px center/16px;
    appearance: none;
}

.file-upload {
    position: relative;
    overflow: hidden;
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload:hover {
    border-color: var(--psu-blue);
    background: rgba(10, 39, 216, 0.05);
}

.file-upload input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.submit-btn {
    background: linear-gradient(135deg, var(--psu-blue) 0%, #4a6cf7 100%);
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(10, 39, 216, 0.3);
}

.submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.tickets-grid {
    display: grid;
    gap: 20px;
    margin-top: 20px;
}

.ticket-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 25px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.ticket-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.ticket-id {
    background: var(--psu-blue);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
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

.admin-response {
    background: #e8f5e8;
    border: 1px solid #d4edda;
    border-radius: 8px;
    padding: 15px;
    margin-top: 15px;
}

.admin-response-header {
    font-weight: 600;
    color: #155724;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.admin-response-content {
    color: #155724;
    line-height: 1.6;
}

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

.debug-toggle {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: #6c757d;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    font-size: 12px;
    cursor: pointer;
    z-index: 1000;
}

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
    
    .ticket-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<body>
    <div class="main-wrapper">
        <!-- Header Sections-->
        <?php include('userpcheader.php'); ?>
        <?php include('usermobileheader.php'); ?> 

        <div class="overlay"></div> 
    
        <!-- Ticket Support Dashboard -->
        <div class="ticket-dashboard">
            <div class="container">
                <!-- Debug Panel (Hidden by default) -->
                <div class="debug-panel hidden" id="debugPanel">
                    <h5>🔍 Debug Information</h5>
                    <p><strong>Session Email:</strong> <?php echo $debug_info['session_email']; ?></p>
                    <p><strong>Session ID:</strong> <?php echo $debug_info['session_id']; ?></p>
                    <p><strong>Session Name:</strong> <?php echo $debug_info['session_name']; ?></p>
                    <p><strong>Tickets Debug:</strong> <?php echo $tickets_debug; ?></p>
                    <p><strong>Total Tickets in DB:</strong> <?php echo $total_tickets; ?></p>
                    <p><strong>User Tickets Found:</strong> <?php echo count($user_tickets); ?></p>
                </div>
                
                <!-- Dashboard Header -->
                <div class="dashboard-header">
                    <h1><i class="fas fa-headset"></i> Support Ticket System</h1>
                    <p>Submit your technical issues and track their progress</p>
                        <?php if (isset($_SESSION['user_name'])): ?>
                        <div style="margin-top: 15px;">
                            <span style="background: var(--psu-yellow); color: var(--text-dark); padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                                Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋
                            </span>
                        </div>
                    <?php endif; ?>
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
                    <h2 style="text-align: center; margin-bottom: 30px; color: var(--psu-blue);">
                        <i class="fas fa-ticket-alt"></i> Submit Support Ticket
                    </h2>
                    
                    <form class="ticket-form" id="ticketForm" method="POST" action="submit_ticket.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="subject"><i class="fas fa-envelope"></i> Subject *</label>
                            <input type="text" id="subject" name="subject" class="form-control" required 
                                   placeholder="Brief description of your issue">
                        </div>

                        <div class="form-group">
                            <label for="description"><i class="fas fa-comment-alt"></i> Description *</label>
                            <textarea id="description" name="description" class="form-control" required 
                                     placeholder="Please provide detailed information about your issue..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="priority"><i class="fas fa-flag"></i> Priority Level</label>
                            <select id="priority" name="priority" class="form-control priority-select">
                                <option value="Low">Low - General inquiry</option>
                                <option value="Medium" selected>Medium - Standard issue</option>
                                <option value="High">High - Urgent issue</option>
                                <option value="Critical">Critical - System down</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="department"><i class="fas fa-building"></i> Department/Program</label>
                            <select id="department" name="department" class="form-control">
                                <option value="">Select your department</option>
                                <option value="BSIT">Bachelor of Science in Information Technology</option>
                                <option value="BSBA">Bachelor of Science in Business Administration</option>
                                <option value="BTLE">Bachelor of Technology and Livelihood Education</option>
                                <option value="BEE">Bachelor of Elementary Education</option>
                                <option value="BSE">Bachelor of Secondary Education</option>
                                <option value="BIT">Bachelor of Industrial Technology</option>
                                <option value="Administration">Administration</option>
                                <option value="Faculty">Faculty</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-paperclip"></i> Attachments (Optional)</label>
                            <div class="file-upload" onclick="document.getElementById('screenshots').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: var(--psu-blue); margin-bottom: 10px;"></i>
                                <p>Click to upload screenshots or documents</p>
                                <small style="color: var(--text-muted);">JPG, PNG, PDF files up to 10MB</small>
                                <input type="file" id="screenshots" name="screenshots[]" multiple 
                                       accept=".jpg,.jpeg,.png,.pdf" style="display: none;" onchange="showFileNames(this)">
                            </div>
                            <div id="fileNames" style="margin-top: 10px;"></div>
                        </div>

                        <button type="submit" class="submit-btn" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            Submit Ticket
                        </button>
                    </form>
                </div>

                <!-- Ticket History Tab -->
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
                                <button onclick="switchTab('submit')" class="submit-btn" style="width: auto; padding: 12px 30px; margin-top: 20px;">
                                    Submit Your First Ticket
                                </button>
                                                                <div style="margin-top: 20px;">                                    <small style="color: var(--text-muted);">                                        If you have submitted tickets and they're not showing, please contact support.                                    </small>                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($user_tickets as $ticket): ?>
                                <div class="ticket-card">
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
                                        <?php echo htmlspecialchars($ticket['description']); ?>
                                    </div>
                                    
                                    <?php if (!empty($ticket['admin_response'])): ?>
                                        <div class="admin-response">
                                            <div class="admin-response-header">
                                                <i class="fas fa-user-shield"></i>
                                                Admin Response
                                                <?php if ($ticket['updated_at']): ?>
                                                    <small style="font-weight: normal; opacity: 0.8;">
                                                        (<?php echo date('M d, Y \a\t g:i A', strtotime($ticket['updated_at'])); ?>)
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            <div class="admin-response-content">
                                                <?php echo nl2br(htmlspecialchars($ticket['admin_response'])); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="ticket-meta">
                                        <div>
                                            <span class="priority-badge priority-<?php echo strtolower($ticket['priority'] ?? 'medium'); ?>">
                                                <?php echo htmlspecialchars($ticket['priority'] ?? 'Medium'); ?>
                                            </span>
                                            <?php if ($ticket['department']): ?>
                                                <span style="margin-left: 8px; padding: 4px 8px; background: #e9ecef; border-radius: 12px; font-size: 11px;">
                                                    <?php echo htmlspecialchars($ticket['department']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <i class="fas fa-calendar"></i>
                                            <?php echo date('M d, Y', strtotime($ticket['created_at'])); ?>
                                            <?php if ($ticket['resolved_at']): ?>
                                                <br><small style="color: var(--success-color);">
                                                    <i class="fas fa-check-circle"></i> 
                                                    Resolved: <?php echo date('M d, Y', strtotime($ticket['resolved_at'])); ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Debug Toggle Button -->
        <button class="debug-toggle" onclick="toggleDebug()">Debug Info</button>

        <!-- Back to Top Button -->
        <a href="#" class="back-to-top">
            <i class="icofont-simple-up"></i>
        </a>
    </div>

    <!-- Include Scripts -->
    <?php include('scripts.php'); ?>
    
    <script>
    // Debug toggle functionality
    function toggleDebug() {
        const debugPanel = document.getElementById('debugPanel');
        debugPanel.classList.toggle('hidden');
    }

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

    // File upload functionality
    function showFileNames(input) {
        const fileNamesDiv = document.getElementById('fileNames');
        fileNamesDiv.innerHTML = '';
        
        if (input.files.length > 0) {
            const fileList = document.createElement('div');
            fileList.style.cssText = 'background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 10px;';
            
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const fileItem = document.createElement('div');
                fileItem.style.cssText = 'display: flex; align-items: center; gap: 10px; margin-bottom: 5px;';
                fileItem.innerHTML = `
                    <i class="fas fa-file" style="color: var(--psu-blue);"></i>
                    <span>${file.name}</span>
                    <small style="color: var(--text-muted);">(${(file.size / 1024 / 1024).toFixed(2)} MB)</small>
                `;
                fileList.appendChild(fileItem);
            }
            
            fileNamesDiv.appendChild(fileList);
        }
    }

    // Form submission with loading state
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<div class="loading-spinner"></div> Submitting...';
        submitBtn.disabled = true;
    });

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i>
            ${message}
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    // Auto-refresh ticket status every 30 seconds when on history tab
    let refreshInterval;
    
    function startAutoRefresh() {
        refreshInterval = setInterval(() => {
            if (document.getElementById('history-tab').classList.contains('active')) {
                location.reload();
            }
        }, 30000);
    }
    
    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    }
    
    // Start auto-refresh on page load
    document.addEventListener('DOMContentLoaded', startAutoRefresh);
    
    // Stop auto-refresh when page is hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            startAutoRefresh();
        }
    });
    
    // Show success message if redirected from form submission
    <?php if (isset($_GET['success'])): ?>
        showNotification('Your ticket has been submitted successfully! We will review it shortly.', 'success');
    <?php endif; ?>
    
    // Show error message if any
    <?php if (isset($_GET['error'])): ?>
        showNotification('<?php echo addslashes($_GET['error']); ?>', 'error');
    <?php endif; ?>
    </script>
</body>

</html> 