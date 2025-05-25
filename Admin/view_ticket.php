<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $ticket_id = intval($_POST['id']);
    
    $sql = "SELECT * FROM tickets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $ticket = $result->fetch_assoc();
        
        // Parse attachments if they exist
        $attachments = [];
        if (!empty($ticket['attachments'])) {
            $attachments = json_decode($ticket['attachments'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $attachments = [];
            }
        }
        
        // Determine status badge class
        $status_class = 'badge-soft-primary';
        switch ($ticket['status']) {
            case 'Open':
                $status_class = 'badge-soft-warning';
                break;
            case 'In Progress':
                $status_class = 'badge-soft-info';
                break;
            case 'Resolved':
                $status_class = 'badge-soft-success';
                break;
            case 'Closed':
                $status_class = 'badge-soft-secondary';
                break;
        }
        
        // Determine priority badge class
        $priority_class = 'badge-soft-secondary';
        switch ($ticket['priority']) {
            case 'Low':
                $priority_class = 'badge-soft-secondary';
                break;
            case 'Medium':
                $priority_class = 'badge-soft-info';
                break;
            case 'High':
                $priority_class = 'badge-soft-warning';
                break;
            case 'Critical':
                $priority_class = 'badge-soft-danger';
                break;
        }
        
        echo '<div class="ticket-detail-container">
            <div class="row">
                <div class="col-md-8">
                    <div class="ticket-header-info">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h4 class="ticket-title">
                                    <i class="fas fa-ticket-alt text-primary me-2"></i>
                                    ' . htmlspecialchars($ticket['subject']) . '
                                </h4>
                                <div class="ticket-meta">
                                    <span class="badge ' . $status_class . ' me-2">' . htmlspecialchars($ticket['status']) . '</span>
                                    <span class="badge ' . $priority_class . '">' . htmlspecialchars($ticket['priority']) . ' Priority</span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="ticket-id-large">
                                    <small class="text-muted">Ticket ID</small>
                                    <div class="h5 mb-0">#' . $ticket['id'] . '</div>
                                </div>
                            </div>
        </div>
    </div>

                    <div class="ticket-content">
                        <h6 class="section-title">
                            <i class="fas fa-align-left me-2"></i>Description
                        </h6>
                        <div class="description-content">
                            ' . nl2br(htmlspecialchars($ticket['description'])) . '
                        </div>
                    </div>';
                    
                    if (!empty($ticket['admin_response'])) {
                        echo '<div class="admin-response mt-4">
                            <h6 class="section-title">
                                <i class="fas fa-reply me-2"></i>Admin Response
                            </h6>
                            <div class="response-content">
                                ' . nl2br(htmlspecialchars($ticket['admin_response'])) . '
                            </div>
                        </div>';
                    }
                    
                echo '</div>
                
                <div class="col-md-4">
                    <div class="ticket-sidebar">
                        <div class="info-section">
                            <h6 class="section-title">
                                <i class="fas fa-user me-2"></i>Submitted By
                            </h6>
                            <div class="user-info">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="assets/images/user-avatar.png" alt="User" class="rounded-circle me-3" style="width: 40px; height: 40px;" onerror="this.src=\'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMjAiIGZpbGw9IiNmOGY5ZmEiLz4KPHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHlsZT0icG9zaXRpb246IGFic29sdXRlOyB0b3A6IDUwJTsgbGVmdDogNTAlOyB0cmFuc2Zvcm06IHRyYW5zbGF0ZSgtNTAlLCAtNTAlKTsiPgo8cGF0aCBkPSJNMjAgMjFWMTlBNCA0IDAgMCAwIDE2IDE1SDhBNCA0IDAgMCAwIDQgMTlWMjEiIHN0cm9rZT0iIzZjNzU3ZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPGNpcmNsZSBjeD0iMTIiIGN5PSI3IiByPSI0IiBzdHJva2U9IiM2Yzc1N2QiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo8L3N2Zz4K\'">
                                    <div>
                                        <div class="fw-bold">' . htmlspecialchars($ticket['name']) . '</div>
                                        <small class="text-muted">' . htmlspecialchars($ticket['email']) . '</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-section">
                            <h6 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>Ticket Details
                            </h6>
                            <div class="detail-list">
                                <div class="detail-item">
                                    <span class="detail-label">Department:</span>
                                    <span class="detail-value">' . (htmlspecialchars($ticket['department']) ?: 'Not specified') . '</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Created:</span>
                                    <span class="detail-value">' . date('M d, Y \a\t g:i A', strtotime($ticket['created_at'])) . '</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Last Updated:</span>
                                    <span class="detail-value">' . date('M d, Y \a\t g:i A', strtotime($ticket['updated_at'])) . '</span>
                                </div>';
                                
                                if ($ticket['resolved_at']) {
                                    echo '<div class="detail-item">
                                        <span class="detail-label">Resolved:</span>
                                        <span class="detail-value">' . date('M d, Y \a\t g:i A', strtotime($ticket['resolved_at'])) . '</span>
                                    </div>';
                                }
                                
                            echo '</div>
                        </div>';
                        
                        // Show attachments if any
                        if (!empty($attachments)) {
                            echo '<div class="info-section">
                                <h6 class="section-title">
                                    <i class="fas fa-paperclip me-2"></i>Attachments (' . count($attachments) . ')
                                </h6>
                                <div class="attachments-list">';
                                
                                foreach ($attachments as $attachment) {
                                    $icon = 'fas fa-file';
                                    if (in_array($attachment['file_type'], ['jpg', 'jpeg', 'png', 'gif'])) {
                                        $icon = 'fas fa-image';
                                    } elseif ($attachment['file_type'] === 'pdf') {
                                        $icon = 'fas fa-file-pdf';
                                    } elseif (in_array($attachment['file_type'], ['doc', 'docx'])) {
                                        $icon = 'fas fa-file-word';
                                    }
                                    
                                    echo '<div class="attachment-item">
                                        <div class="d-flex align-items-center">
                                            <i class="' . $icon . ' text-primary me-3"></i>
                                            <div class="flex-grow-1">
                                                <div class="attachment-name">' . htmlspecialchars($attachment['original_name']) . '</div>
                                                <small class="text-muted">' . number_format($attachment['file_size'] / 1024, 1) . ' KB</small>
                                            </div>
                                            <a href="' . htmlspecialchars($attachment['file_path']) . '" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>';
                                }
                                
                            echo '</div>
                            </div>';
                        }
                        
                    echo '</div>
                </div>
            </div>
            
            <div class="modal-actions mt-4">
                <div class="d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn btn-warning" onclick="updateStatus(' . $ticket['id'] . ')">
                            <i class="fas fa-edit me-2"></i>Update Status
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .ticket-detail-container {
            padding: 0;
        }
        
        .ticket-header-info {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
        }
        
        .ticket-title {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .ticket-meta .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.8rem;
        }
        
        .ticket-id-large {
            text-align: center;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 2px solid #0A27D8;
        }
        
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .description-content, .response-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0A27D8;
            line-height: 1.6;
        }
        
        .response-content {
            border-left-color: #28a745;
        }
        
        .ticket-sidebar {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-section:last-child {
            margin-bottom: 0;
        }
        
        .user-info {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .detail-list {
            background: white;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .detail-value {
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .attachments-list {
            background: white;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }
        
        .attachment-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .attachment-item:last-child {
            border-bottom: none;
        }
        
        .attachment-name {
            font-weight: 500;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .modal-actions {
            border-top: 2px solid #e9ecef;
            padding-top: 20px;
        }
        
        @media (max-width: 768px) {
            .ticket-detail-container .row {
                flex-direction: column-reverse;
            }
            
            .ticket-sidebar {
                margin-bottom: 20px;
            }
        }
        </style>';
        
    } else {
        echo '<div class="text-center py-4">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h5>Ticket Not Found</h5>
            <p class="text-muted">The requested ticket could not be found.</p>
        </div>';
    }
    
    $stmt->close();
} else {
    echo '<div class="text-center py-4">
        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
        <h5>Invalid Request</h5>
        <p class="text-muted">Invalid ticket ID provided.</p>
    </div>';
}

$conn->close();
?> 