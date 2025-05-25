<?php
include 'db_conn.php'; // Ensure this file connects to your database

// Check if the required POST parameters are set
if (isset($_POST['studentID'], $_POST['studentName'], $_POST['studentEmail'], $_POST['studentGender'], 
          $_POST['studentBirthdate'], $_POST['studentAge'], $_POST['studentProgram'], $_POST['studentAddress'], $_POST['studentPhoneNumber'])) {
    
    // Escape user input to protect against SQL Injection
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $studentName = $conn->real_escape_string($_POST['studentName']);
    $studentEmail = $conn->real_escape_string($_POST['studentEmail']);
    $studentGender = $conn->real_escape_string($_POST['studentGender']);
    $studentBirthdate = $conn->real_escape_string($_POST['studentBirthdate']);
    $studentAge = $conn->real_escape_string($_POST['studentAge']);
    $studentProgram = $conn->real_escape_string($_POST['studentProgram']);
    $studentAddress = $conn->real_escape_string($_POST['studentAddress']);
    $studentPhoneNumber = $conn->real_escape_string($_POST['studentPhoneNumber']);

    // Update the student record in the database
    $sql = "UPDATE students 
            SET FullName = '$studentName', 
                EmailAddress = '$studentEmail', 
                Gender = '$studentGender', 
                Birthdate = '$studentBirthdate', 
                Age = '$studentAge', 
                BachelorProgram = '$studentProgram', 
                Address = '$studentAddress',
                PhoneNumber = '$studentPhoneNumber' 
            WHERE StudentID = '$studentID'";

    if ($conn->query($sql) === TRUE) {
        // Success
        echo json_encode(['success' => true, 'message' => 'Student record updated successfully.']);
    } else {
        // Error in query
        echo json_encode(['error' => 'Failed to update student: ' . $conn->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid input data. Please fill in all required fields.']);
}

$conn->close();

?>
