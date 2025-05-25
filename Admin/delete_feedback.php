<?php
include 'db_conn.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    try {
        // Check if feedback table exists
        $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'feedback'");
        if (mysqli_num_rows($table_check) == 0) {
            echo json_encode(['success' => false, 'error' => 'Feedback table does not exist']);
            exit;
        }
        
        // Delete feedback from the correct table
        $sql = "DELETE FROM feedback WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    echo json_encode(['success' => true, 'message' => 'Feedback deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Feedback not found or already deleted']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Database error: ' . $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to prepare statement: ' . $conn->error]);
        }
        
    } catch (Exception $e) {
        error_log("Delete feedback error: " . $e->getMessage());
        echo json_encode(['success' => false, 'error' => 'Server error occurred']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method or missing ID parameter']);
}

$conn->close();
?>
