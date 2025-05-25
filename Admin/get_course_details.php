<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query to get the course details by CourseID
    $sql = "SELECT * FROM courses WHERE CourseID = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}

$conn->close();
?>
