<?php
include 'db_conn.php'; // Ensure this file connects to your database

// Check if the required POST parameters are set
if (isset($_POST['fullname'], $_POST['teacherEmail'], $_POST['department'], $_POST['designation'], $_POST['pnumber'], $_POST['gender'])) {
    // Escape user input to protect against SQL Injection
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $teacherEmail = $conn->real_escape_string($_POST['teacherEmail']);
    $department = $conn->real_escape_string($_POST['department']);
    $designation = $conn->real_escape_string($_POST['designation']);
    $pnumber = $conn->real_escape_string($_POST['pnumber']);
    $gender = $conn->real_escape_string($_POST['gender']);
    
    // Insert data into teachers table
    $sql = "INSERT INTO teachers (FullName, Email, Department, Designation, PhoneNumber, Gender) 
            VALUES ('$fullname', '$teacherEmail', '$department', '$designation', '$pnumber', '$gender')";

    if ($conn->query($sql) === TRUE) {
        // Get the last inserted ID (Assuming 'id' is the primary key)
        $new_teacher_id = $conn->insert_id;
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Teacher added successfully',
            'teacher_id' => $new_teacher_id
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add teacher: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data. Please fill in all required fields.']);
}

$conn->close();
?>
