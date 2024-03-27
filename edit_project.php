<!-- edit_project.php -->
<?php
include 'server.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $project_id = $_POST['project_id'];
    $project_title = $_POST['project_title'];
    $description = $_POST['description'];
    $student_name = $_POST['student_name'];
    $student_id = $_POST['student_id'];
    // Update project details in the database
    $query = "UPDATE projects SET project_title = '$project_title', description = '$description', student_name = '$student_name', student_id = '$student_id' WHERE project_id = $project_id";
    if ($conn->query($query) === TRUE) {
        // Redirect back to admin dashboard after successful update
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating project: " . $conn->error;
    }
    $conn->close();
}
?>
