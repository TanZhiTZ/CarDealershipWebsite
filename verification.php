<?php
include 'config/config.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify token
    $sql = "SELECT * FROM user WHERE token = ? AND is_verified = 0 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, verify user
        $sql = "UPDATE user SET is_verified = 1 WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);

        if ($stmt->execute()) {
            echo "Email verification successful! You can now log in.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid token or email already verified.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No token provided.";
}
