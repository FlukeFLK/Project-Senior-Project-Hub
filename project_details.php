<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Details - Senior Project Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .download-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .download-btn:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Senior Project Hub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="admin_dashboard.php">Main</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="upload_form.php">Upload</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <div class="container mt-4">
    <?php
// Include your database connection
include 'server.php';

// Check if project_id parameter exists in the URL
if(isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    // Fetch project details from the projects table
    $query = "SELECT * FROM projects WHERE project_id = $project_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display project details
        echo '<h2>'.htmlspecialchars($row["project_title"]).'</h2>';
        echo '<p>'.htmlspecialchars($row["description"]).'</p>';
        echo '<p><strong>Owner:</strong> '.htmlspecialchars($row["student_name"]).'</p>';
        echo '<p><strong>Student ID:</strong> '.htmlspecialchars($row["student_id"]).'</p>';
        
        
        // Display PDF document if available
        $document_query = "SELECT * FROM document_files WHERE project_id = $project_id";
        $document_result = $conn->query($document_query);
        if ($document_result->num_rows > 0) {
            $document_row = $document_result->fetch_assoc();
            echo '<embed src="'.htmlspecialchars($document_row["file_path"]).'" type="application/pdf" width="100%" height="600px" />';
        }

        // Display video if available
        $video_query = "SELECT * FROM video_files WHERE project_id = $project_id";
        $video_result = $conn->query($video_query);
        if ($video_result->num_rows > 0) {
            $video_row = $video_result->fetch_assoc();
            echo '<video width="100%" height="auto" controls>';
            echo '<source src="'.htmlspecialchars($video_row["file_path"]).'" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
        }

        // Display code file if available
        $code_query = "SELECT * FROM code_files WHERE project_id = $project_id";
        $code_result = $conn->query($code_query);
        if ($code_result->num_rows > 0) {
            $code_row = $code_result->fetch_assoc();
            echo '<a href="'.htmlspecialchars($code_row["file_path"]).'" class="download-btn" download>Download Code</a>';
        }
        
    } else {
        echo 'Project not found.';
    }
} else {
    echo 'Invalid project ID.';
}
?>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
