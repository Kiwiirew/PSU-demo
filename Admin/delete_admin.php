<?php
include 'db_conn.php';

if (isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    $sql = "DELETE FROM admin_accounts WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }
}

$conn->close();
?>
