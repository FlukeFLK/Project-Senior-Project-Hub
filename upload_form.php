<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Project Files - Senior Project Hub</title>
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
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Upload Project Files</h2>
        <form action="upload_files.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="student_id" class="form-label">Student ID:</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <div class="mb-3">
                <label for="studentName" class="form-label">Student Name:</label>
                <input type="text" class="form-control" id="studentName" name="studentName" required>
            </div>
            <div class="mb-3">
                <label for="projectTitle" class="form-label">Project Title:</label>
                <input type="text" class="form-control" id="projectTitle" name="projectTitle" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Project Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="documentFile" class="form-label">Document File:</label>
                <input type="file" class="form-control" id="documentFile" name="documentFile">
            </div>
            <div class="mb-3">
                <label for="videoFile" class="form-label">Video File:</label>
                <input type="file" class="form-control" id="videoFile" name="videoFile">
            </div>
            <div class="mb-3">
                <label for="codeFile" class="form-label">Project Code (ZIP/RAR):</label>
                <input type="file" class="form-control" id="codeFile" name="codeFile">
            </div>
            <button type="submit" class="btn btn-primary">Upload Files</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
