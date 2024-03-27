<!-- admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Senior Project Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <!-- Logout Button -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Uploaded Projects</h2>

        <!-- Search Bar -->
        <form action="admin_dashboard.php" method="get" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search by project title, student name, or student ID" name="search" aria-describedby="searchBtn">
                <button class="btn btn-primary" type="submit" id="searchBtn">Search</button>
            </div>
        </form>

        <!-- Category Dropdown -->
        <form action="admin_dashboard.php" method="get" class="mb-3">
            <div class="input-group">
                <select class="form-select" name="category" aria-label="Select category">
                    <option selected>Sort by...</option>
                    <option value="title">A-Z Project Title</option>
                    <option value="uploaded_at">Uploaded At</option>
                    <option value="student_id">Student ID</option>
                </select>
                <button class="btn btn-primary" type="submit">Sort</button>
            </div>
        </form>

        <?php
        include 'server.php';

        // Fetch and display project data from database based on search query and category
        if(isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $query = "SELECT * FROM projects WHERE project_title LIKE '%$search%' OR student_name LIKE '%$search%' OR student_id LIKE '%$search%'";
        } else {
            $query = "SELECT * FROM projects";
        }

        if(isset($_GET['category'])) {
            $category = $_GET['category'];
            if ($category === 'title') {
                $query .= " ORDER BY project_title ASC";
            } elseif ($category === 'uploaded_at') {
                $query .= " ORDER BY uploaded_at DESC";
            } elseif ($category === 'student_id') {
                $query .= " ORDER BY student_id ASC";
            }
        }

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Display project details and links for editing and deleting
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.htmlspecialchars($row["project_title"]).'</h5>';
                echo '<p class="card-text">'.htmlspecialchars($row["description"]).'</p>';
                echo '<p class="card-text"><small class="text-muted">Owner: '.htmlspecialchars($row["student_name"]).'</small></p>';
                echo '<p class="card-text"><small class="text-muted">Student ID: '.htmlspecialchars($row["student_id"]).'</small></p>';
                echo '<a href="project_details.php?project_id='.$row['project_id'].'" class="btn btn-primary">View Details</a>';
                echo '<a href="edit_form.php?project_id='.$row['project_id'].'" class="btn btn-secondary">Edit</a>';
                echo '<a href="delete_project.php?project_id='.$row['project_id'].'" class="btn btn-danger">Delete</a>';
                echo '</div></div>';
            }
        } else {
            echo 'No projects found.';
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to redirect to admin_dashboard.php with selected category
        function changeCategory(category) {
            window.location.href = 'admin_dashboard.php?category=' + category;
        }
    </script>
</body>
</html>
