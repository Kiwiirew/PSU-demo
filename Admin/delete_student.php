<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    $conn->begin_transaction();
    
    try {
        $sql = "DELETE FROM enrollment WHERE StudentID = '$id'";
        if (!$conn->query($sql)) {
            throw new Exception("Error deleting from enrollment: " . $conn->error);
        }
        
        $sql = "DELETE FROM students WHERE StudentID = '$id'";
        if (!$conn->query($sql)) {
            throw new Exception("Error deleting from students: " . $conn->error);
        }
        
        $conn->commit();
        echo 'success';
    } catch (Exception $e) {
        $conn->rollback();
        echo 'error';
    }
}

$conn->close();
?>
