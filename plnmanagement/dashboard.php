<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PLN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        /* 🔹 Style Global */
        body {
            background-color: #f5f5f5; /* Abu-abu minimalis */
            color: #333;
            font-family: 'Montserrat', sans-serif;
        }

        /* 🔹 Navbar Transparan */
        .navbar {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* 🔹 Home (Dengan Background Gambar) */
        #home {
            background: url('https://images.unsplash.com/photo-1596518413004-7a48ddfe42e2?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: black;
            font-size: 2rem;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        /* 🔹 Section Styling */
        section {
            padding: 100px 0;
            text-align: center;
        }

        /* 🔹 About (Tanpa Gambar, Abu-Abu Minimalis) */
        #about {
            background-color: #e0e0e0;
            padding: 80px 0;
        }

        /* 🔹 Services & Contact */
        #services {
            background-color: #ffc107;
            color: black;
        }

        #contact {
            background-color: #e0e0e0;
            color: black;
        }

        /* 🔹 Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">PLN Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="backend/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ✅ Home (Dengan Background Gambar) -->
<section id="home">
    <div class="container">
    <h1 class="fw-bold">PLN Data Management</h1>
        <p>Kelola & Analisis Data Jam Nyala PLN</p>
        <a href="#services" class="btn btn-warning">View Services</a>
    </div>
</section>

<!-- ✅ About (Tanpa Gambar, Abu-Abu Minimalis) -->
<section id="about">
    <div class="container">
    <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="fw-bold">Data Management Simplified</h1>
                <p class="fst-italic">Empower your data experience</p>
                <hr style="width: 50px; border: 2px solid black; margin-left: 0;">
            </div>
            <div class="col-md-6">
                <p>
                    PLN Data Management offers an intuitive platform to visualize and manage your data efficiently. 
                    Tailored for the needs of users, our website enhances data accessibility with features like 
                    interactive tables and line charts, simple filtering options, and the ability to export data 
                    in PDF and Excel formats. 
                </p>
                <p>
                    Our file management system allows for easy uploads, edits, and downloads, while a secure login 
                    system ensures that up to three administrators can manage the data effectively. 
                    Experience seamless data management in Surabaya, ID.
                </p>
                <a href="#contact" class="btn btn-outline-dark fw-bold">GET IN TOUCH</a>
            </div>
        </div>
    </div>
</section>

<!-- ✅ Services -->
<section id="services">
    <div class="container">
    <h2 class="fw-bold">Our Services</h2>
        <p>Berbagai layanan pengelolaan listrik PLN.</p>
        <a href="jam_nyala.php" class="btn btn-light mt-3">Jam Nyala</a>
    </div>
</section>

<!-- ✅ Contact -->
<!-- ✅ Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row align-items-start">
            <!-- Informasi Kontak -->
            <div class="col-md-4 text-start">
                <h5 class="fw-bold">Get in touch</h5>
                <p>📧 <a href="mailto:pln123@pln.co.id">pln123@pln.co.id</a></p>

                <h5 class="fw-bold">Location</h5>
                <p>📍 <a href="https://maps.app.goo.gl/oedL56cSVpqYDEvD7" target="_blank">
                    Jl. Ngagel Tim. No.14, Pucang Sewu, Kec. Gubeng, Surabaya, Jawa Timur 60283
                </a></p>
                <hr style="width: 50px; border: 2px solid black; margin-left: 0;">
            </div>

            <!-- Peta di Tengah -->
            <div class="col-md-4 text-center">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.3508038402213!2d112.75671691478377!3d-7.277891594743021!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbf738af5041%3A0xf9dbcb8a8c5fcb6!2sJl.%20Ngagel%20Tim.%20No.14%2C%20Pucang%20Sewu%2C%20Kec.%20Gubeng%2C%20Surabaya%2C%20Jawa%20Timur%2060283!5e0!3m2!1sen!2x!4v1645000000000" 
                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

            <!-- Hours di Sebelah Kanan -->
            <div class="col-md-3 text-end">
                <h5 class="fw-bold">Hours</h5>  
                <div class="hours-container">
                    <div class="hour-item"><span>Monday</span> <span>8:00am – 12:00am</span></div>
                    <div class="hour-item"><span>Tuesday</span> <span>8:00am – 12:00am</span></div>
                    <div class="hour-item"><span>Wednesday</span> <span>8:00am – 12:00am</span></div>
                    <div class="hour-item"><span>Thursday</span> <span>8:00am – 12:00am</span></div>
                    <div class="hour-item"><span>Friday</span> <span>8:00am – 12:00am</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Styling untuk jam agar sejajar */
    .hours-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        text-align: right;
    }

    .hour-item {
        display: flex;
        justify-content: space-between;
        width: 250px; /* Sesuaikan agar rapi */
        font-family: Arial, sans-serif;
    }
</style>



<!-- ✅ Footer -->
<footer>
    <p>© 2025 PLN Data Management | All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
