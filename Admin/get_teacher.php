<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $teacherID = intval($_GET['id']);

    // Fetch teacher details from the database
    $sql = "SELECT TeacherID, FullName, Email, Department, Designation, Gender, PhoneNumber FROM teachers WHERE TeacherID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacherID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'teacher' => $teacher]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Teacher not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

$conn->close();
?>
