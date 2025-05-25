<?php
include 'db_conn.php';

$sql = "SELECT * FROM teachers ORDER BY Department, FullName";
$result = $conn->query($sql);

$teachers = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $teachers[] = array(
            'FullName' => htmlspecialchars($row['FullName']),
            'Department' => htmlspecialchars($row['Department']),
            'Designation' => htmlspecialchars($row['Designation']),
            'Email' => htmlspecialchars($row['Email']),
            'PhoneNumber' => htmlspecialchars($row['PhoneNumber']),
            'Gender' => htmlspecialchars($row['Gender'])
        );
    }
}

header('Content-Type: application/json');
echo json_encode($teachers);
?> 