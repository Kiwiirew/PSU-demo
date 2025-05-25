<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['acctype'])) {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required"
        ]);
        exit;
    }

    // Sanitize inputs
    $adminUsername = strip_tags(trim($_POST['username']));
    $adminPassword = strip_tags(trim($_POST['password']));
    $adminAccType = strip_tags(trim($_POST['acctype']));

    // Validate account type
    $validAccTypes = ['admin', 'superadmin'];
    if (!in_array($adminAccType, $validAccTypes)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid account type"
        ]);
        exit;
    }

    try {
        // Check if username already exists
        $checkStmt = $conn->prepare("SELECT username FROM admin_accounts WHERE username = ?");
        $checkStmt->bind_param("s", $adminUsername);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Username already exists"
            ]);
            exit;
        }
        $checkStmt->close();

        // Insert new admin
        $stmt = $conn->prepare("INSERT INTO admin_accounts (username, password, acctype) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $adminUsername, $adminPassword, $adminAccType);

        if ($stmt->execute()) {
            $newAdminId = $stmt->insert_id;
            echo json_encode([
                "success" => true,
                "message" => "Admin created successfully",
                "newAdmin" => [
                    "id" => $newAdminId,
                    "username" => $adminUsername,
                    "acctype" => $adminAccType
                ]
            ]);
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to create admin: " . $e->getMessage()
        ]);
    }

    $conn->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}
?>
