<?php
session_start();

include('db_conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM teachers WHERE FullName = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['Password']) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_fullname'] = $row['FullName'];
            echo 'success';
        } else {
            echo 'Invalid username or password';
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM admin_accounts WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                $_SESSION['admin_username'] = $username;
                echo 'success';
            } else {
                echo 'Invalid username or password';
            }
        } else {
            echo 'Invalid username or password';
        }
    }

    $stmt->close();
}

$conn->close();
?>
