<?php
session_start();
include 'server.php'; // Ensure this points to your actual database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $studentName = $conn->real_escape_string($_POST['studentName']);
    $projectTitle = $conn->real_escape_string($_POST['projectTitle']);
    $description = $conn->real_escape_string($_POST['description']);

    // Insert project details into the projects table including student_id
    $stmt = $conn->prepare("INSERT INTO projects (student_id, student_name, project_title, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $student_id, $studentName, $projectTitle, $description);
    $stmt->execute();
    $project_id = $stmt->insert_id; // Get the ID of the newly inserted project record
    $stmt->close();



    // Handle and insert document file upload
    if (!empty($_FILES["documentFile"]["name"])) {
        $documentPath = uploadFile($_FILES["documentFile"], "documents/");
        if ($documentPath !== false) {
            insertFileRecord($conn, $project_id, $documentPath, 'document_files');
        }
    }

    // Handle and insert video file upload
    if (!empty($_FILES["videoFile"]["name"])) {
        $videoPath = uploadFile($_FILES["videoFile"], "videos/");
        if ($videoPath !== false) {
            insertFileRecord($conn, $project_id, $videoPath, 'video_files');
        }
    }

    // Handle and insert code file upload
    if (!empty($_FILES["codeFile"]["name"])) {
        $codePath = uploadFile($_FILES["codeFile"], "code/");
        if ($codePath !== false) {
            insertFileRecord($conn, $project_id, $codePath, 'code_files');
        }
    }

    // Redirect to the main dashboard
    header("Location: admin_dashboard.php?view=main");
    exit(); // Terminate script to ensure the redirect is followed
}

// Function to handle file upload
function uploadFile($file, $subDir) {
    $targetDir = "uploads/" . $subDir;
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;

    if(move_uploaded_file($file["tmp_name"], $targetFilePath)){
        return $targetFilePath; // Return the path of the uploaded file
    } else{
        return false; // Error uploading file
    }
}

// Function to insert file record into the database
function insertFileRecord($conn, $project_id, $filePath, $tableName) {
    $fileName = basename($filePath);
    $stmt = $conn->prepare("INSERT INTO $tableName (project_id, file_name, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $project_id, $fileName, $filePath);
    $stmt->execute();
    $stmt->close();
}
?>
