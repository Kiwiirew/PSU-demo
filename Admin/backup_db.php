<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin_username'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Access denied');
}

// Database configuration
include 'db_conn.php';

// Get current date for the backup filename
$date = date('Y-m-d-H-i-s');
$backup_file = 'database_backup_' . $date . '.sql';
$backup_path = '../backups/' . $backup_file;

// Create backups directory if it doesn't exist
if (!file_exists('../backups')) {
    mkdir('../backups', 0777, true);
}

// Set appropriate headers for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $backup_file . '"');

// Open output buffer
ob_start();

// Get all tables
$tables = array();
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

// Cycle through each table
foreach ($tables as $table) {
    // Get create table syntax
    $result = $conn->query("SHOW CREATE TABLE `$table`");
    $row = $result->fetch_row();
    echo "\n\n" . $row[1] . ";\n\n";
    
    // Get table data
    $result = $conn->query("SELECT * FROM `$table`");
    while ($row = $result->fetch_row()) {
        $values = array_map(function($value) use ($conn) {
            if ($value === null) {
                return 'NULL';
            }
            return "'" . $conn->real_escape_string($value) . "'";
        }, $row);
        
        echo "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n";
    }
}

// Get output buffer contents and clean it
$output = ob_get_clean();

// Output the SQL content
echo $output;

// Close connection
$conn->close();
?> 