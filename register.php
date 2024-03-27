<?php
// Include the database connection from server.php
include 'server.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $terms = isset($_POST['terms']); // Check if terms were accepted

    // Basic validation
    if (!empty($firstName) && !empty($lastName) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($username) && !empty($password) && ($password === $confirmPassword) && $terms) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the INSERT statement to add the user to the database
        $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $hashedPassword);

        // Execute the statement and check if the user is registered successfully
        if ($stmt->execute()) {
            // Close the prepared statement
            $stmt->close();
            // Close the database connection
            $conn->close();
            // Redirect to userindex.html
            header("Location: userindex.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // If validation fails
        echo "Please ensure all fields are filled out correctly.";
    }
}

// Close the database connection
$conn->close();
?>
