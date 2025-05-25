<?php
include 'db_conn.php';

if (isset($_POST['studentID'])) {
    $studentID = $conn->real_escape_string($_POST['studentID']);

    $query = "SELECT * FROM students WHERE StudentID = '$studentID'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(['error' => 'Student not found']);
    }
}

$conn->close();
?>
