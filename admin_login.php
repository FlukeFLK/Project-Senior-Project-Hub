<?php
session_start(); // Start a session

// Include database connection
include 'server.php'; // Adjust this line according to your database connection setup

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // In a real app, you'd hash and verify this

    // SQL to check the admin's credentials
    $sql = "SELECT id FROM admin WHERE username = ? AND password = ?"; // Note: Storing and comparing plain-text passwords like this is insecure!
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login success: Set session variables and redirect to the admin dashboard
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username; // Or fetch from the database

        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Login failed: Redirect back to the login page or show an error
        echo "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
