<?php
include 'db_conn.php';

header('Content-Type: application/json');

function deleteTicketAndFiles($conn, $ticketId) {
    try {
        // Start transaction
        $conn->begin_transaction();
        
        // First, get ticket details including attachments
        $selectSql = "SELECT attachments FROM tickets WHERE id = ?";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->bind_param("i", $ticketId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        
        if ($result->num_rows === 0) {
            $conn->rollback();
            return ['success' => false, 'error' => 'Ticket not found'];
        }
        
        $ticket = $result->fetch_assoc();
        $selectStmt->close();
        
        // Delete associated files
        if (!empty($ticket['attachments'])) {
            $attachments = json_decode($ticket['attachments'], true);
            if (is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    if (isset($attachment['file_path']) && file_exists($attachment['file_path'])) {
                        unlink($attachment['file_path']);
                    }
                }
            }
        }
        
        // Delete ticket logs
        $logDeleteSql = "DELETE FROM ticket_logs WHERE ticket_id = ?";
        $logDeleteStmt = $conn->prepare($logDeleteSql);
        $logDeleteStmt->bind_param("i", $ticketId);
        $logDeleteStmt->execute();
        $logDeleteStmt->close();
        
        // Delete the ticket
        $deleteSql = "DELETE FROM tickets WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $ticketId);
        
        if ($deleteStmt->execute()) {
            if ($deleteStmt->affected_rows > 0) {
                $conn->commit();
                $deleteStmt->close();
                return ['success' => true, 'message' => 'Ticket deleted successfully'];
            } else {
                $conn->rollback();
                $deleteStmt->close();
                return ['success' => false, 'error' => 'Ticket not found or already deleted'];
            }
        } else {
            $conn->rollback();
            $deleteStmt->close();
            return ['success' => false, 'error' => 'Database error: ' . $deleteStmt->error];
        }
        
    } catch (Exception $e) {
        $conn->rollback();
        error_log("Ticket deletion error: " . $e->getMessage());
        return ['success' => false, 'error' => 'Failed to delete ticket'];
    }
}

// Main processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $ticketId = intval($_POST['id']);
        
        if ($ticketId > 0) {
            $result = deleteTicketAndFiles($conn, $ticketId);
            
            if ($result['success']) {
                echo 'success';
            } else {
                echo $result['error'];
            }
        } else {
            echo 'Invalid ticket ID';
        }
    } else {
        echo 'Missing ticket ID';
    }
} else {
    echo 'Invalid request method';
}

$conn->close();
?> 