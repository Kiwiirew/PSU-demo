<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);
    
    $conn->begin_transaction();
    
    try {
        $sql = "DELETE FROM teachingassignments WHERE TeacherID = '$id'";
        if (!$conn->query($sql)) {
            throw new Exception("Error deleting from teachingassignments: " . $conn->error);
        }
        
        $sql = "DELETE FROM teachers WHERE TeacherID = '$id'";
        if (!$conn->query($sql)) {
            throw new Exception("Error deleting from teachers: " . $conn->error);
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
