<?php
include 'db_conn.php';

header('Content-Type: application/json');

try {
    // Validate input
    if (!isset($_POST['CourseID']) || !isset($_POST['CourseCode']) || !isset($_POST['Subject']) || 
        !isset($_POST['Department']) || !isset($_POST['Room'])) {
        throw new Exception('Missing required fields');
    }

    $courseId = $_POST['CourseID'];
    $courseCode = $_POST['CourseCode'];
    $subject = $_POST['Subject'];
    $department = $_POST['Department'];
    $room = $_POST['Room'];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE courses SET CourseCode=?, Subject=?, Department=?, Room=? WHERE CourseID=?");
    $stmt->bind_param("ssssi", $courseCode, $subject, $department, $room, $courseId);
    
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Course updated successfully',
            'data' => [
                'CourseID' => $courseId,
                'CourseCode' => $courseCode,
                'Subject' => $subject,
                'Department' => $department,
                'Room' => $room
            ]
        ]);
    } else {
        throw new Exception('Failed to update course');
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?> 