<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Convert to integer for security
    
    // First check if feedback table exists
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'feedback'");
    if (mysqli_num_rows($table_check) == 0) {
        echo "<div class='alert alert-warning'>
                <i class='fas fa-exclamation-triangle me-2'></i>
                Feedback system is being initialized. Please refresh the page.
              </div>";
        exit;
    }
    
    $sql = "SELECT * FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $rating = $row['rating'] ?? 3;
            $stars = str_repeat('⭐', intval($rating));
            
            echo "<div class='feedback-details-content'>
                    <div class='row mb-3'>
                        <div class='col-md-6'>
                            <h6><i class='fas fa-user me-2'></i>Contact Information</h6>
                            <p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>
                            <p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>
                        </div>
                        <div class='col-md-6'>
                            <h6><i class='fas fa-info-circle me-2'></i>Feedback Details</h6>
                            <p><strong>Status:</strong> <span class='badge badge-soft-primary'>" . htmlspecialchars($row['status'] ?? 'New') . "</span></p>
                            <p><strong>Rating:</strong> " . $stars . " (" . $rating . "/5)</p>
                            <p><strong>Date:</strong> " . date('M d, Y H:i', strtotime($row['created_at'])) . "</p>
                        </div>
                    </div>
                    
                    <div class='mb-3'>
                        <h6><i class='fas fa-comment me-2'></i>Feedback Message</h6>
                        <div class='alert alert-light'>
                            " . nl2br(htmlspecialchars($row['message'])) . "
                        </div>
                    </div>";
                    
            if (!empty($row['admin_response'])) {
                echo "<div class='mb-3'>
                        <h6><i class='fas fa-reply me-2'></i>Admin Response</h6>
                        <div class='alert alert-info'>
                            " . nl2br(htmlspecialchars($row['admin_response'])) . "
                        </div>
                      </div>";
            }
            
            echo "</div>";
        } else {
            echo "<div class='alert alert-warning'>
                    <i class='fas fa-exclamation-triangle me-2'></i>
                    Feedback not found or may have been deleted.
                  </div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>
                <i class='fas fa-times me-2'></i>
                Database error: " . htmlspecialchars($conn->error) . "
              </div>";
    }
} else {
    echo "<div class='alert alert-danger'>
            <i class='fas fa-times me-2'></i>
            Invalid request method or missing parameters.
          </div>";
}
?>
