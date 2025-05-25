<?php
include 'db_conn.php';

// Add new columns to courses table
$alterQueries = [
    "ALTER TABLE courses ADD COLUMN duration VARCHAR(50) NOT NULL DEFAULT '4 Years' AFTER future_impact",
    "ALTER TABLE courses ADD COLUMN total_subjects INT NOT NULL DEFAULT 60 AFTER duration",
    "ALTER TABLE courses ADD COLUMN level VARCHAR(50) NOT NULL DEFAULT 'Secondary' AFTER total_subjects",
    "ALTER TABLE courses ADD COLUMN language VARCHAR(50) NOT NULL DEFAULT 'English' AFTER level",
    "ALTER TABLE courses ADD COLUMN certificate VARCHAR(10) NOT NULL DEFAULT 'Yes' AFTER language",
    "ALTER TABLE courses ADD COLUMN portal_link VARCHAR(255) NOT NULL DEFAULT 'https://psu362.campus-erp.com/portal/' AFTER certificate"
];

foreach ($alterQueries as $query) {
    if (!mysqli_query($conn, $query)) {
        die("Error executing query: " . $query . "\nError: " . mysqli_error($conn));
    }
}

echo "Migration completed successfully!";
?>
