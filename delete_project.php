<?php
// Include your database connection
include 'server.php';

// Check if project_id parameter exists in the URL
if(isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    // Delete related records in document_files table
    $delete_document_query = "DELETE FROM document_files WHERE project_id = $project_id";
    if ($conn->query($delete_document_query) === TRUE) {
        // Delete related records in code_files table
        $delete_code_query = "DELETE FROM code_files WHERE project_id = $project_id";
        if ($conn->query($delete_code_query) === TRUE) {
            // Delete related records in video_files table
            $delete_video_query = "DELETE FROM video_files WHERE project_id = $project_id";
            if ($conn->query($delete_video_query) === TRUE) {
                // Delete the project from the projects table
                $delete_project_query = "DELETE FROM projects WHERE project_id = $project_id";
                if ($conn->query($delete_project_query) === TRUE) {
                    // Redirect back to admin dashboard after successful deletion
                    header('Location: admin_dashboard.php');
                    exit;
                } else {
                    echo 'Error deleting project: ' . $conn->error;
                }
            } else {
                echo 'Error deleting related video files: ' . $conn->error;
            }
        } else {
            echo 'Error deleting related code files: ' . $conn->error;
        }
    } else {
        echo 'Error deleting related document files: ' . $conn->error;
    }
} else {
    echo 'Invalid project ID.';
}
?>
