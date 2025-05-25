<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $teacherID = intval($_POST['id']);
    $sql = "DELETE FROM teachers WHERE TeacherID = $teacherID";

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
