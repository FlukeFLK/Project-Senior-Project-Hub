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

    // Prepare the SQL query to delete the favorite record
    $delete_query = "DELETE FROM favorites WHERE user_id = ? AND project_id = ?";
    
    // Prepare and bind the statement
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $user_id, $project_id);
    
    // Execute the query
    if ($stmt->execute()) {
        // Check the referer URL
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            if (strpos($referer, "seniorproject_details.php") !== false) {
                // Redirect back to seniorproject_details.php if unfavourited from there
                header("Location: seniorproject_details.php?id=$project_id");
            } else if (strpos($referer, "user_favorite.php") !== false) {
                // Redirect back to user_favorite.php if unfavourited from there
                header("Location: user_favorite.php");
            } else {
                // Default redirect
                header("Location: user_favorite.php");
            }
        } else {
            // Default redirect
            header("Location: user_favorite.php");
        }
        exit;
    } else {
        echo "Error deleting favorite: " . $stmt->error;
    }
} else {
    echo "Project ID not found in GET data.";
}
?>
