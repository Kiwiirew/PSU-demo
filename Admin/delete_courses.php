<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $courseID = intval($_POST['id']);
    $sql = "DELETE FROM courses WHERE id = $courseID";

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
