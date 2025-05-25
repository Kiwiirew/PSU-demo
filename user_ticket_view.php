<?php
session_start();
include('admin/db_conn.php');
require_once 'session_check.php';

// Check if user is authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php?error=Please login to view tickets");
    exit();
}

// Get ticket ID from URL
$ticket_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$ticket_id) {
            header("Location: unified_ticket_support.php?error=Invalid ticket ID");
    exit();
}

// Get ticket details - ensure user can only view their own tickets
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM tickets WHERE id = ? AND email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $ticket_id, $user_email);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    header("Location: unified_ticket_support.php?error=Ticket not found or access denied");
    exit();
}

$ticket = $result->fetch_assoc();
$stmt->close();

// Parse attachments if they exist
$attachments = [];
if (!empty($ticket['attachments'])) {
    $attachments = json_decode($ticket['attachments'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $attachments = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

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

body {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.ticket-view-container {
    max-width: 1000px;
    margin: 100px auto 50px;
    padding: 0 20px;
}

.ticket-header {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    border-left: 5px solid var(--psu-blue);
}

.ticket-content {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.ticket-id {
    background: var(--psu-blue);
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 15px;
}

.ticket-subject {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 15px;
    line-height: 1.3;
}

.ticket-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 14px;
}

.status-open {
    background: #fff3cd;
    color: #856404;
}

.status-in-progress {
    background: #d1ecf1;
    color: #0c5460;
}

.status-resolved {
    background: #d4edda;
    color: #155724;
}

.status-closed {
    background: #f8d7da;
    color: #721c24;
}

.priority-low {
    background: #e2e3e5;
    color: #383d41;
}

.priority-medium {
    background: #d1ecf1;
    color: #0c5460;
}

.priority-high {
    background: #fff3cd;
    color: #856404;
}

.priority-critical {
    background: #f8d7da;
    color: #721c24;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--psu-blue);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.description-content {
    font-size: 16px;
    line-height: 1.6;
    color: var(--text-dark);
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid var(--psu-blue);
}

.admin-response {
    background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
    border: 2px solid #28a745;
    border-radius: 15px;
    padding: 25px;
    margin-top: 30px;
}

.admin-response .section-title {
    color: #28a745;
}

.response-content {
    background: white;
    padding: 20px;
    border-radius: 10px;
    font-size: 16px;
    line-height: 1.6;
    color: var(--text-dark);
}

.ticket-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.detail-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
}

.detail-label {
    font-weight: 600;
    color: var(--text-muted);
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
}

.detail-value {
    font-size: 16px;
    color: var(--text-dark);
    font-weight: 500;
}

.attachments-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

.attachment-item {
    background: #f8f9fa;
    border: 2px dashed var(--border-color);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
}

.attachment-item:hover {
    border-color: var(--psu-blue);
    background: #f0f7ff;
}

.attachment-icon {
    font-size: 24px;
    color: var(--psu-blue);
}

.attachment-info {
    flex: 1;
}

.attachment-name {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.attachment-size {
    color: var(--text-muted);
    font-size: 14px;
}

.download-btn {
    background: var(--psu-blue);
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.download-btn:hover {
    background: #0921b8;
    color: white;
    text-decoration: none;
}

.back-btn {
    background: var(--psu-yellow);
    color: var(--text-dark);
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    margin-bottom: 30px;
}

.back-btn:hover {
    background: #ffe21a;
    color: var(--text-dark);
    text-decoration: none;
    transform: translateY(-2px);
}

.no-response {
    background: #fff3cd;
    border: 2px dashed #ffc107;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    color: #856404;
    font-style: italic;
}

@media (max-width: 768px) {
    .ticket-view-container {
        margin: 50px auto;
        padding: 0 15px;
    }
    
    .ticket-header,
    .ticket-content,
    .attachments-section {
        padding: 20px;
    }
    
    .ticket-subject {
        font-size: 24px;
    }
    
    .ticket-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .ticket-details {
        grid-template-columns: 1fr;
    }
}
</style>

<body>
    <div class="main-wrapper">
        <!-- Header Sections -->
        <?php include('userpcheader.php'); ?>
        <?php include('usermobileheader.php'); ?>

        <div class="overlay"></div>

        <div class="ticket-view-container">
            <!-- Back Button -->
                            <a href="unified_ticket_support.php" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Tickets
            </a>

            <!-- Ticket Header -->
            <div class="ticket-header">
                <div class="ticket-id">#<?php echo $ticket['id']; ?></div>
                <h1 class="ticket-subject"><?php echo htmlspecialchars($ticket['subject']); ?></h1>
                
                <div class="ticket-meta">
                    <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $ticket['status'])); ?>">
                        <i class="fas fa-circle"></i> <?php echo htmlspecialchars($ticket['status']); ?>
                    </span>
                    <span class="status-badge priority-<?php echo strtolower($ticket['priority']); ?>">
                        <i class="fas fa-flag"></i> <?php echo htmlspecialchars($ticket['priority']); ?> Priority
                    </span>
                    <?php if ($ticket['department']): ?>
                        <span class="status-badge" style="background: #e9ecef; color: #495057;">
                            <i class="fas fa-building"></i> <?php echo htmlspecialchars($ticket['department']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Ticket Details -->
                <div class="ticket-details">
                    <div class="detail-item">
                        <span class="detail-label">Submitted By</span>
                        <div class="detail-value"><?php echo htmlspecialchars($ticket['name']); ?></div>
                        <small class="text-muted"><?php echo htmlspecialchars($ticket['email']); ?></small>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Created</span>
                        <div class="detail-value"><?php echo date('M d, Y \a\t g:i A', strtotime($ticket['created_at'])); ?></div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Last Updated</span>
                        <div class="detail-value"><?php echo date('M d, Y \a\t g:i A', strtotime($ticket['updated_at'])); ?></div>
                    </div>
                    <?php if ($ticket['resolved_at']): ?>
                        <div class="detail-item">
                            <span class="detail-label">Resolved</span>
                            <div class="detail-value"><?php echo date('M d, Y \a\t g:i A', strtotime($ticket['resolved_at'])); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ticket Description -->
            <div class="ticket-content">
                <h2 class="section-title">
                    <i class="fas fa-align-left"></i>
                    Description
                </h2>
                <div class="description-content">
                    <?php echo nl2br(htmlspecialchars($ticket['description'])); ?>
                </div>
            </div>

            <!-- Admin Response -->
            <?php if (!empty($ticket['admin_response'])): ?>
                <div class="admin-response">
                    <h2 class="section-title">
                        <i class="fas fa-reply"></i>
                        Admin Response
                    </h2>
                    <div class="response-content">
                        <?php echo nl2br(htmlspecialchars($ticket['admin_response'])); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="ticket-content">
                    <h2 class="section-title">
                        <i class="fas fa-hourglass-half"></i>
                        Admin Response
                    </h2>
                    <div class="no-response">
                        <i class="fas fa-clock"></i>
                        No admin response yet. We'll get back to you soon!
                    </div>
                </div>
            <?php endif; ?>

            <!-- Attachments -->
            <?php if (!empty($attachments)): ?>
                <div class="attachments-section">
                    <h2 class="section-title">
                        <i class="fas fa-paperclip"></i>
                        Attachments (<?php echo count($attachments); ?>)
                    </h2>
                    
                    <?php foreach ($attachments as $attachment): ?>
                        <?php
                        $icon = 'fas fa-file';
                        if (in_array(strtolower($attachment['file_type']), ['jpg', 'jpeg', 'png', 'gif'])) {
                            $icon = 'fas fa-image';
                        } elseif (strtolower($attachment['file_type']) === 'pdf') {
                            $icon = 'fas fa-file-pdf';
                        } elseif (in_array(strtolower($attachment['file_type']), ['doc', 'docx'])) {
                            $icon = 'fas fa-file-word';
                        }
                        ?>
                        <div class="attachment-item">
                            <i class="<?php echo $icon; ?> attachment-icon"></i>
                            <div class="attachment-info">
                                <div class="attachment-name"><?php echo htmlspecialchars($attachment['original_name']); ?></div>
                                <div class="attachment-size"><?php echo number_format($attachment['file_size'] / 1024, 1); ?> KB</div>
                            </div>
                            <a href="<?php echo htmlspecialchars($attachment['file_path']); ?>" target="_blank" class="download-btn">
                                <i class="fas fa-download"></i>
                                Download
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <?php include('footer.php'); ?>
    </div>

    <!-- Scripts -->
    <?php include('scripts.php'); ?>
</body>
</html> 