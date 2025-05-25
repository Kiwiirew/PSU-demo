<?php
include 'db_conn.php';

// Fetch all courses from the database
$sql = "SELECT * FROM courses ORDER BY CourseID DESC"; // You can change the order as needed
$result = $conn->query($sql);

$courses = [];

if ($result->num_rows > 0) {
    // Loop through the result and fetch each row
    while ($row = $result->fetch_assoc()) {
        // Add each course to the courses array
        $courses[] = [
            'CourseID' => $row['CourseID'],
            'CourseCode' => $row['CourseCode'],
            'BachelorProgram' => $row['BachelorProgram'],
            'Subject' => $row['Subject'],
            'Room' => $row['Room'],
            'Department' => $row['Department']
        ];
    }

    // Return the data as JSON
    echo json_encode($courses);
} else {
    // If no courses found, return an empty array
    echo json_encode([]);
}

$conn->close();
?>
