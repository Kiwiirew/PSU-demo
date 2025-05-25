<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $studentID = intval($_POST['id']);
    $sql = "DELETE FROM students WHERE StudentID = $studentID";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'Error: ' . $conn->error;
    }
} else {
    echo 'No ID provided';
}

$conn->close();
?>
