<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.html");
    exit;
}

$username = htmlspecialchars($_SESSION["username"]); // Assuming username is stored in session

// Define default search query and category filter
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Determine the current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Define how many projects to display per page
$projects_per_page = 6;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $projects_per_page;

// Include your database connection
include 'server.php';

// Construct the SQL query based on search query and category filter
$query = "SELECT * FROM projects";

if (!empty($search_query)) {
    $query .= " WHERE project_title LIKE '%$search_query%' OR student_name LIKE '%$search_query%' OR student_id LIKE '%$search_query%'";
}

if (!empty($category_filter)) {
    if ($category_filter == 'title') {
        $query .= " ORDER BY project_title ASC";
    } elseif ($category_filter == 'uploaded_at') {
        $query .= " ORDER BY uploaded_at ASC";
    } elseif ($category_filter == 'student_id') {
        $query .= " ORDER BY student_id ASC";
    }
}
// Determine current page
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// Append pagination to the SQL query
$query .= " LIMIT $projects_per_page OFFSET $offset";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senior Project Hub</title>
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

    

    <!-- Senior Projects Section -->
<section id="uploadedProjects" class="mt-5">
    <div class="container">
        <h2 class="mb-4">Senior Projects</h2>
        <!-- Search Bar -->
<section id="searchBar" class="mt-4">
    <div class="container">
        <form action="seniorproject.php" method="GET" class="mb-3">
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
        <form action="seniorproject.php" method="GET" class="mb-3">
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


        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row["project_title"]) . '</h5>';
                    echo '<p class="card-text"><strong>Owner:</strong> ' . htmlspecialchars($row["student_name"]) . '</p>';
                    echo '<p class="card-text"><strong>Student ID:</strong> ' . htmlspecialchars($row["student_id"]) . '</p>';
                    echo '<a href="seniorproject_details.php?id=' . $row["project_id"] . '" class="btn btn-primary" style="background-color: #00766a; border-color: #00766a;">View Details</a>'; // Link to view project details

                    echo '</div></div></div>';
                }
            } else {
                echo 'No projects found.';
            }
            ?>
        </div>

                <!-- Pagination -->
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mt-4">
                <?php
                // Determine total number of pages
                $total_pages_query = "SELECT COUNT(*) as total FROM projects";
                $total_result = $conn->query($total_pages_query);
                $total_rows = $total_result->fetch_assoc()['total'];
                $total_pages = ceil($total_rows / $projects_per_page);

                // Display pagination links
                for ($i = 1; $i <= $total_pages; $i++) {
                    // Add 'active' class to the current page link
                    $active_class = ($i == $page) ? 'active' : '';

                    echo '<li class="page-item ' . $active_class . '"><a class="page-link" href="seniorproject.php?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </nav>

    </div>
</section>


    <!-- Remaining content unchanged... -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
