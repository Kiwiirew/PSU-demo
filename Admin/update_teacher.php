<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacherID = intval($_POST['TeacherID']);
    $fullName = $conn->real_escape_string($_POST['FullName']);
    $email = $conn->real_escape_string($_POST['Email']);
    $department = $conn->real_escape_string($_POST['Department']);
    $designation = $conn->real_escape_string($_POST['Designation']);
    $gender = $conn->real_escape_string($_POST['Gender']);
    $phoneNumber = $conn->real_escape_string($_POST['PhoneNumber']);

    $sql = "UPDATE teachers SET 
                FullName = '$fullName', 
                Email = '$email', 
                Department = '$department', 
                Designation = '$designation', 
                Gender = '$gender', 
                PhoneNumber = '$phoneNumber'
            WHERE TeacherID = $teacherID";

    if ($conn->query($sql) === TRUE) {
        $updatedTeacher = [
            'TeacherID' => $teacherID,
            'FullName' => $fullName,
            'Email' => $email,
            'Department' => $department,
            'Designation' => $designation,
            'Gender' => $gender,
            'PhoneNumber' => $phoneNumber
        ];
        echo json_encode(['status' => 'success', 'message' => 'Teacher updated successfully', 'data' => $updatedTeacher]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating teacher: ' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
