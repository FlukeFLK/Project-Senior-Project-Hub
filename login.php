<?php
session_start(); // Start the session.

include 'server.php'; // Include your database connection script.

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Retrieve submitted username and password
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            // Password is correct, so start a new session and save the username
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $username; // Store username in session variable
            
            // Redirect user to user index page
            header("Location: userindex.php");
            exit;
        } else{
            // Display an error message if password is not valid
            echo "The password you entered was not valid.";
        }
    } else{
        // Display an error message if username doesn't exist
        echo "No account found with that username.";
    }

    $stmt->close();
    $conn->close();
}
?>
