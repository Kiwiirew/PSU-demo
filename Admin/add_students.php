<?php
// Include the database connection file
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $studentName = mysqli_real_escape_string($conn, $_POST['studentName']);
    $studentEmail = mysqli_real_escape_string($conn, $_POST['studentEmail']);
    $studentBirthdate = mysqli_real_escape_string($conn, $_POST['studentBirthdate']);
    $studentAge = mysqli_real_escape_string($conn, $_POST['studentAge']);
    $studentGender = mysqli_real_escape_string($conn, $_POST['studentGender']);
    $studentAddress = mysqli_real_escape_string($conn, $_POST['studentAddress']);
    $studentPhone = mysqli_real_escape_string($conn, $_POST['studentPhone']);
    $studentProgram = mysqli_real_escape_string($conn, $_POST['studentProgram']);

    // Prepare the SQL query to insert data into the students table
    $sql = "INSERT INTO students (FullName, EmailAddress, Birthdate, Age, Gender, Address, PhoneNumber, BachelorProgram) 
            VALUES ('$studentName', '$studentEmail', '$studentBirthdate', '$studentAge', '$studentGender', '$studentAddress', '$studentPhone', '$studentProgram')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student added successfully!'); window.location.href = 'students.php';</script>";
    } else {
        // Check if the error is due to a duplicate entry
        if (strpos(mysqli_error($conn), 'Duplicate entry') !== false) {
            echo "<script>alert('Error: Duplicate entry for email address. Please use a different email.'); window.location.href = 'students.php';</script>";
        } else {
            // Display other errors
            $errorMessage = mysqli_real_escape_string($conn, mysqli_error($conn));
            echo "<script>alert('Error: $errorMessage'); window.location.href = 'students.php';</script>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = 'students.php';</script>";
}
?>
