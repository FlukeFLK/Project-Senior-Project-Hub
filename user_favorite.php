<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}

$username = htmlspecialchars($_SESSION["username"]); // Assuming username is stored in session

// Define pagination variables
$results_per_page = 6; // Number of results per page

// Include your database connection
include 'server.php';

// Retrieve total number of favorite projects for the logged-in user
$user_id = $_SESSION['id']; // Assuming user ID is stored in session
$count_query = "SELECT COUNT(*) AS total FROM projects p INNER JOIN favorites f ON p.project_id = f.project_id WHERE f.user_id = $user_id";
$count_result = $conn->query($count_query);
$row = $count_result->fetch_assoc();
$total_projects = $row['total'];

// Calculate total number of pages
$total_pages = ceil($total_projects / $results_per_page);

// Determine current page
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// Calculate SQL LIMIT starting number for the results on the displaying page
$start_index = ($page - 1) * $results_per_page;

// Retrieve favorite projects for the logged-in user with pagination
$favorite_query = "SELECT p.project_id, p.project_title, p.description, p.student_name, p.student_id
                   FROM projects p
                   INNER JOIN favorites f ON p.project_id = f.project_id
                   WHERE f.user_id = $user_id";

// Check if a search query is provided
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $favorite_query .= " AND (p.project_title LIKE '%$search%' OR p.student_name LIKE '%$search%' OR p.student_id LIKE '%$search%')";
}

// Check if a category filter is provided
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
if(!empty($category_filter)) {
    // Apply sorting based on the selected category
    switch($category_filter) {
        case 'title':
            $favorite_query .= " ORDER BY p.project_title ASC";
            break;
        case 'uploaded_at':
            $favorite_query .= " ORDER BY p.uploaded_at DESC";
            break;
        case 'student_id':
            $favorite_query .= " ORDER BY p.student_id ASC";
            break;
    }
}

// Apply pagination
$favorite_query .= " LIMIT $start_index, $results_per_page";

$favorite_result = $conn->query($favorite_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Favorites - Senior Project Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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
                        <!-- Removed "Register" and "Sign In & Up" options -->
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

    <!-- Favorite List Section -->
    <section id="favoriteList" class="mt-5">
        <div class="container">
            <h2>Your Favorite Projects</h2>
            <!-- Search Bar -->
<section id="searchBar" class="mt-4">
    <div class="container">
        <form action="user_favorite.php" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by project title, student name, or student ID" name="search" aria-describedby="searchBtn">
                <button class="btn btn-primary" type="submit" id="searchBtn" style="background-color: #00766a; border-color: #00766a;">Search</button>
            </div>
        </form>
    </div>
</section>

<!-- Category Dropdown -->
<section id="categoryDropdown" class="mt-4">
    <div class="container">
        <form action="user_favorite.php" method="GET" class="mb-3">
            <div class="input-group">
                <select class="form-select" name="category" aria-label="Select category">
                    <option value="">Sort by...</option>
                    <option value="title" <?php echo ($category_filter == 'title') ? 'selected' : ''; ?>>A-Z Project Title</option>
                    <option value="uploaded_at" <?php echo ($category_filter == 'uploaded_at') ? 'selected' : ''; ?>>Uploaded At</option>
                    <option value="student_id" <?php echo ($category_filter == 'student_id') ? 'selected' : ''; ?>>Student ID</option>
                </select>
                <button class="btn btn-primary" type="submit" style="background-color: #00766a; border-color: #00766a;">Sort</button>
            </div>
        </form>
    </div>
</section>

            <div class="row">
                <?php
                if ($favorite_result->num_rows > 0) {
                    while ($row = $favorite_result->fetch_assoc()) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-4">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["project_title"]) . '</h5>';
                        echo '<p class="card-text"><strong>Owner:</strong> ' . htmlspecialchars($row["student_name"]) . '</p>';
                        echo '<p class="card-text"><strong>Student ID:</strong> ' . htmlspecialchars($row["student_id"]) . '</p>';
                        echo '<a href="seniorproject_details.php?id=' . $row["project_id"] . '" class="btn btn-primary mr-2" style="background-color: #00766a; border-color: #00766a;">View Details</a>'; // Link to view project details
                        echo '<a href="unfavorite.php?project_id=' . $row["project_id"] . '" class="btn btn-danger" style="background-color: #f8d7da; color: #721c24;">Unfavorite</a>'; // Link to unfavorite project
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col">';
                    echo '<p class="text-center">You have not favorited any projects yet.</p>';
                    echo '</div>';
                }
                ?>
            </div>

            <!-- Pagination Section -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php
                    // Generate pagination links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="user_favorite.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                    ?>
                </ul>
            </nav>
            <!-- End Pagination Section -->

        </div>
    </section>
    <!-- End Favorite List Section -->

    <!-- Remaining content unchanged... -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
