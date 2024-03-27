<!-- edit_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project - Senior Project Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Project</h2>
        <?php
        include 'server.php';

        // Retrieve project details based on project_id from query parameter
        if(isset($_GET['project_id'])) {
            $project_id = $_GET['project_id'];
            $query = "SELECT * FROM projects WHERE project_id = $project_id";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Pre-populate form fields with existing project details
                $existing_project_title = $row["project_title"];
                $existing_description = $row["description"];
                $existing_student_name = $row["student_name"];
                $existing_student_id = $row["student_id"];
            } else {
                echo 'Project not found.';
                exit;
            }
        } else {
            echo 'Invalid project ID.';
            exit;
        }
        ?>
        <form action="edit_project.php" method="POST">
            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
            <div class="mb-3">
                <label for="project_title" class="form-label">Project Title</label>
                <input type="text" class="form-control" id="project_title" name="project_title" value="<?php echo htmlspecialchars($existing_project_title); ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($existing_description); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="student_name" class="form-label">Owner (Student Name)</label>
                <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo htmlspecialchars($existing_student_name); ?>">
            </div>
            <div class="mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo htmlspecialchars($existing_student_id); ?>">
            </div>
            <!-- Include other input fields for project details -->

            <button type="submit" class="btn btn-primary">Update Project</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
