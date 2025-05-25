<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the values from the form
    $courseID = intval($_POST['CourseID']);
    $courseCode = $conn->real_escape_string($_POST['CourseCode']);
    $subject = $conn->real_escape_string($_POST['Subject']);
    $department = $conn->real_escape_string($_POST['Department']);
    $room = $conn->real_escape_string($_POST['Room']);

    // Update the course data in the database
    $sql = "UPDATE courses SET 
                CourseCode = '$courseCode', 
                Subject = '$subject', 
                Department = '$department', 
                Room = '$room'
            WHERE CourseID = $courseID";

    if ($conn->query($sql) === TRUE) {
        // Return updated data for the table
        $updatedCourse = [
            'CourseID' => $courseID,
            'CourseCode' => $courseCode,
            'Subject' => $subject,
            'Department' => $department,
            'Room' => $room
        ];
        echo json_encode(['status' => 'success', 'message' => 'Course updated successfully', 'data' => $updatedCourse]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating course: ' . $conn->error]);
    }

    $conn->close();
}
?>
