<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}

// Check if user_id is set in the session
if (!isset($_SESSION['id'])) {
    echo "User ID not found in session.";
    exit;
}

// Include your database connection
include 'server.php';

// Check if project_id is set in the GET data
if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $user_id = $_SESSION['id']; // Assuming the user ID is stored in 'id'

    // Prepare the SQL query to check if the project is already favorited by the user
    $favorite_query = "SELECT COUNT(*) AS count FROM favorites WHERE user_id = ? AND project_id = ?";
    
    // Prepare and bind the statement
    $stmt = $conn->prepare($favorite_query);
    $stmt->bind_param("ii", $user_id, $project_id);
    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        
        if ($count == 0) {
            // Project is not favorited, so insert it into favorites table
            $insert_query = "INSERT INTO favorites (user_id, project_id) VALUES (?, ?)";
            
            // Prepare and bind the statement
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ii", $user_id, $project_id);
            
            // Execute the query
            if ($stmt->execute()) {
                // Redirect back to the project details page
                header("Location: seniorproject_details.php?id=$project_id");
                exit;
            } else {
                echo "Error inserting favorite: " . $stmt->error;
            }
        } else {
            echo "Project already favorited by the user.";
        }
    } else {
        echo "Error checking favorite: " . $stmt->error;
    }
} else {
    echo "Project ID not found in GET data.";
}
?>
