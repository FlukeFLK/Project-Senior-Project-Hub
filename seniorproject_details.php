<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}

// Include your database connection
include 'server.php';

// Check if project_id is set in the URL
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    // Retrieve project details from the database
    $query = "SELECT * FROM projects WHERE project_id = $project_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $project_title = htmlspecialchars($row["project_title"]);
        $student_name = htmlspecialchars($row["student_name"]);
        $student_id = htmlspecialchars($row["student_id"]);
        $description = htmlspecialchars($row["description"]); // Fetching description from the database
        // Add more fields if needed
    } else {
        // If project_id not found, redirect to seniorproject.php or display an error message
        header("Location: seniorproject.php");
        exit;
    }
} else {
    // If project_id is not set in the URL, redirect to seniorproject.php or display an error message
    header("Location: seniorproject.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senior Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .download-btn {
            background-color: #00766a; /* Green */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #218838;
        }

        .favorite-btn,
        .unfavorite-btn {
            background-color: #f8d7da; /* Red */
            color: #721c24;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 4px 2px;
            cursor: pointer;
        }

        .favorite-btn:hover,
        .unfavorite-btn:hover {
            background-color: #e0a8af;
        }

        .file-section {
            margin-bottom: 20px;
        }

        .file-section-title {
            font-size: 20px;
            color: #00766a; /* Green */
            margin-bottom: 10px;
        }

        .file-container {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .video-container {
            margin-bottom: 20px;
        }

        .video-container video {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src=".\image\logo_circle_eng_big.png" alt="Library Logo" width="100" height="100">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="userindex.php">Main</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="seniorproject.php">Senior Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_favorite.php">My Favorite</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Signed in as <strong><?php echo $_SESSION['username']; ?></strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Project Details Section -->
<section id="projectDetails" class="mt-5">
    <div class="container">
        <h2>Project Details</h2>

        <!-- Document Files Section -->
        <div class="file-section">
            <div class="file-section-title">Document Files</div>
            <?php
            $document_query = "SELECT * FROM document_files WHERE project_id = $project_id";
            $document_result = $conn->query($document_query);
            if ($document_result->num_rows > 0) {
                while ($document_row = $document_result->fetch_assoc()) {
                    echo '<div class="file-container">';
                    echo '<embed src="'.htmlspecialchars($document_row["file_path"]).'" type="application/pdf" width="100%" height="1000px" />';
                    echo '</div>';
                }
            }
            ?>
        </div>
        <!-- Project Details Section -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $project_title; ?></h5>
                <p class="card-text"><strong>Description:</strong> <?php echo $description; ?></p> <!-- Displaying description -->
                <p class="card-text"><strong>Owner:</strong> <?php echo $student_name; ?></p>
                <p class="card-text"><strong>Student ID:</strong> <?php echo $student_id; ?></p>
                <?php
                // Display code files
                $code_query = "SELECT * FROM code_files WHERE project_id = $project_id";
                $code_result = $conn->query($code_query);
                if ($code_result->num_rows > 0) {
                    while ($code_row = $code_result->fetch_assoc()) {
                        echo '<a href="'.htmlspecialchars($code_row["file_path"]).'" class="download-btn" download>Download Code Here</a>';
                        // Check if project is favorited by the user
                        $favorite_check_query = "SELECT * FROM favorites WHERE user_id = {$_SESSION['id']} AND project_id = $project_id";
                        $favorite_check_result = $conn->query($favorite_check_query);
                        if ($favorite_check_result->num_rows > 0) {
                            // Project is favorited, display unfavorite button
                            echo '<a href="unfavorite.php?project_id=' . $project_id . '" class="unfavorite-btn">Unfavorite</a>';
                        } else {
                            // Project is not favorited, display favorite button
                            echo '<a href="favorite.php?project_id=' . $project_id . '" class="favorite-btn">Favorite</a>';
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Video Files Section -->
        <div class="file-section">
            <div class="file-section-title">Video Files</div>
            <?php
            $video_query = "SELECT * FROM video_files WHERE project_id = $project_id";
            $video_result = $conn->query($video_query);
            if ($video_result->num_rows > 0) {
                while ($video_row = $video_result->fetch_assoc()) {
                    echo '<div class="video-container">';
                    echo '<video controls>';
                    echo '<source src="'.htmlspecialchars($video_row["file_path"]).'" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        
    </div>
</section>

<!-- Remaining content unchanged... -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
