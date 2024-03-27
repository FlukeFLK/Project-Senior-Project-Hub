<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.html");
    exit;
}

$username = htmlspecialchars($_SESSION["username"]); // Assuming username is stored in session

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
    <!-- Carousel Section -->
<section id="carouselSection">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src=".\image\Untitled-1.jpg" class="d-block w-100" alt="Image 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Explore Innovative Senior Projects</h5>
                    <p>Discover a diverse range of senior projects developed by talented students, showcasing their creativity and innovation.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src=".\image\Untitled-2.jpg" class="d-block w-100" alt="Image 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Collaborate and Network</h5>
                    <p>Join a vibrant community of students and mentors, collaborate on projects, and expand your professional network.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src=".\image\Untitled-3.jpg" class="d-block w-100" alt="Image 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Recognition and Achievement</h5>
                    <p>Gain recognition for your hard work and dedication, and celebrate your achievements within the senior project community.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

    <!-- About Senior Project Hub Section -->
    <section id="aboutSection" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">About Senior Project Hub</h2>
            <p class="lead text-center">Senior Project Hub is a platform dedicated to showcasing the innovative and creative projects developed by senior students. Our mission is to provide a centralized hub for students to share their projects, collaborate with peers, and gain recognition for their hard work and dedication.</p>
        </div>
    </section>

    <!-- Services Section -->
<section id="servicesSection" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Services</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src=".\image\service1.jpg" alt="Project Showcase" class="service-icon mb-3">
                        <h5 class="card-title">Project Showcase</h5>
                        <p class="card-text">Showcase your senior projects to a wide audience and gain recognition for your hard work.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src=".\image\service2.jpg" alt="Collaboration" class="service-icon mb-3">
                        <h5 class="card-title">Collaboration</h5>
                        <p class="card-text">Collaborate with peers and mentors to enhance your projects and explore new ideas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src=".\image\service3.jpg" alt="Recognition" class="service-icon mb-3">
                        <h5 class="card-title">Recognition</h5>
                        <p class="card-text">Gain recognition for your achievements and contributions to the senior project community.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <!-- Address Section -->
<section id="addressSection" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Location</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <!-- Google Map Embed Code -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.240789630345!2d100.09218587597856!3d14.75545968574944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e22631cebc6dc9%3A0xe274f13472b2b907!2z4LiV4Lil4Liy4LiU4Liq4Liy4Lih4LiK4Li44LiB!5e0!3m2!1sth!2sth!4v1708123151418!5m2!1sth!2sth" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Senior Project Hub</h5>
                        <p>Samchuk Market Street</p>
                        <p>Samchuk, Suphanburi, 72130</p>
                        <p>Phone: 085-372-1798</p>
                        <p>Email: phacharapon.work@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Creator Section -->
        <section id="creator" class="mt-5 mb-5">
            <div class="container">
                <h2 class="text-center mb-5">Creator</h2>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center creator-card">
                        <img src=".\image\creator.jpg" class="img-fluid rounded-circle creator-image mb-3" alt="Creator Image">
                        <div class="creator-details">
                            <h2>Phacharapon Pakchuen</h2>
                                <p class="text-muted">Founder & Full Developer</p>
                                <p class="text-muted">Email: phacharapon.work@gmail.com</p>
                                <p class="text-muted">Phone: 0853721798</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <!-- Footer Section -->
    <footer id="footerSection" class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 Senior Project Hub. All rights reserved.</p>
                </div>
                <div class="col-md-6">
                    <p class="text-end mb-0">Designed and developed by 631310031 Phacharapon Pakchuen</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
