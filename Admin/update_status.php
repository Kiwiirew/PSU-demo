<?php
// Include your database connection file
include 'db_conn.php';

header('Content-Type: application/json');

// Function to handle ticket status updates
function updateTicketStatus($conn, $data) {
    $ticketId = intval($data['ticketId']);
    $newStatus = $data['newStatus'];
    $adminResponse = $data['adminResponse'] ?? '';
    
    // Validate status
    $validStatuses = ['Open', 'In Progress', 'Resolved', 'Closed'];
    if (!in_array($newStatus, $validStatuses)) {
        return ['success' => false, 'error' => 'Invalid status'];
    }
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Update ticket status and admin response
        $resolvedAt = ($newStatus === 'Resolved' || $newStatus === 'Closed') ? 'NOW()' : 'NULL';
        
        $sql = "UPDATE tickets SET 
                status = ?, 
                admin_response = ?, 
                updated_at = NOW(),
                resolved_at = " . $resolvedAt . "
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newStatus, $adminResponse, $ticketId);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Log the status change
                $logSql = "INSERT INTO ticket_logs (ticket_id, action, details, created_at) 
                          VALUES (?, 'status_update', ?, NOW())";
                
                $logStmt = $conn->prepare($logSql);
                $logDetails = json_encode([
                    'old_status' => 'Unknown', // We could query this if needed
                    'new_status' => $newStatus,
                    'admin_response' => $adminResponse
                ]);
                $logStmt->bind_param("is", $ticketId, $logDetails);
                $logStmt->execute();
                $logStmt->close();
                
                $conn->commit();
                
                // Get updated ticket info
                $ticketSql = "SELECT name, email, subject FROM tickets WHERE id = ?";
                $ticketStmt = $conn->prepare($ticketSql);
                $ticketStmt->bind_param("i", $ticketId);
                $ticketStmt->execute();
                $ticketResult = $ticketStmt->get_result();
                $ticket = $ticketResult->fetch_assoc();
                $ticketStmt->close();
                
                // Send notification email (optional - implement later)
                // sendStatusUpdateNotification($ticket, $newStatus, $adminResponse);
                
                return [
                    'success' => true, 
                    'message' => 'Ticket status updated successfully',
                    'new_status' => $newStatus,
                    'ticket_id' => $ticketId
                ];
            } else {
                $conn->rollback();
                return ['success' => false, 'error' => 'Ticket not found or no changes made'];
            }
        } else {
            $conn->rollback();
            return ['success' => false, 'error' => 'Database error: ' . $stmt->error];
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Ticket status update error: " . $e->getMessage());
        return ['success' => false, 'error' => 'Failed to update ticket status'];
    }
}

// Function to handle feedback status updates
function updateFeedbackStatus($conn, $data) {
    $feedbackId = intval($data['feedbackId']);
    $newStatus = $data['newStatus'];
    $adminResponse = $data['adminResponse'] ?? '';
    
    // Validate status
    $validStatuses = ['New', 'Reviewed', 'Resolved'];
    if (!in_array($newStatus, $validStatuses)) {
        return ['success' => false, 'error' => 'Invalid status'];
    }
    
    try {
        $sql = "UPDATE feedback SET 
                status = ?, 
                admin_response = ?, 
                updated_at = NOW()
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newStatus, $adminResponse, $feedbackId);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $stmt->close();
                return [
                    'success' => true, 
                    'message' => 'Feedback status updated successfully',
                    'new_status' => $newStatus,
                    'feedback_id' => $feedbackId
                ];
            } else {
                $stmt->close();
                return ['success' => false, 'error' => 'Feedback not found or no changes made'];
            }
        } else {
            $stmt->close();
            return ['success' => false, 'error' => 'Database error: ' . $stmt->error];
        }
        
    } catch (Exception $e) {
        error_log("Feedback status update error: " . $e->getMessage());
        return ['success' => false, 'error' => 'Failed to update feedback status'];
    }
}

// Create ticket_logs table if it doesn't exist
function createTicketLogsTable($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS ticket_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ticket_id INT NOT NULL,
        action VARCHAR(50) NOT NULL,
        details JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_ticket_id (ticket_id),
        INDEX idx_action (action),
        INDEX idx_created_at (created_at)
    )";
    
    $conn->query($sql);
}

// Main processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Create logs table if needed
        createTicketLogsTable($conn);
        
        // Determine if this is a ticket or feedback update
        if (isset($_POST['ticketId'])) {
            $result = updateTicketStatus($conn, $_POST);
        } elseif (isset($_POST['feedbackId'])) {
            $result = updateFeedbackStatus($conn, $_POST);
        } else {
            $result = ['success' => false, 'error' => 'Missing required parameters'];
        }
        
        echo json_encode($result);
        
    } catch (Exception $e) {
        error_log("Update status error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Server error occurred']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>
