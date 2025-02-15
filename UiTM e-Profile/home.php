<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - UiTM e-Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('images/download (4).jpeg'); /* Tukar URL ke lokasi gambar anda */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgba(26, 188, 156, 0.9); /* Warna navbar dengan ketelusan */
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        .hero-section {
            text-align: center;
            padding: 100px 20px; /* Jarak dalaman supaya teks tengah */
            background: rgba(0, 0, 0, 0.6); /* Lapisan hitam separuh telus di belakang teks */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .btn {
            font-size: 1.2rem;
            padding: 12px 25px;
            margin: 10px;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-custom {
            background-color: #1abc9c;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #16a085;
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(26, 188, 156, 0.5);
        }

        .btn-secondary {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #2980b9;
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.5);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.5);
        }

        .container {
            text-align: center;
            margin-top: 40px;
        }

        .container-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap; /* Supaya butang responsif */
        }

        .container-buttons a {
            text-decoration: none;
            width: auto;
            margin: 10px;
        }

        /* Style untuk butang dalam keadaan mobile */
        @media (max-width: 768px) {
            .container-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">UiTM e-Profile</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <?php if ($loggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">login</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Log Masuk</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to UiTM e-Profile</h1>
        <p>Create and access your profile easily here</p>
    </div>

    <!-- Butang utama untuk pengguna yang belum log masuk -->
    <div class="container">
        <?php if (!$loggedIn): ?>
            <div class="container-buttons">
                <a href="signup.php" class="btn btn-custom">Daftar Akaun</a>
                <a href="login.php" class="btn btn-secondary">Log Masuk</a>
            </div>
        <?php else: ?>
            <div class="container-buttons">
                <a href="profile.php" class="btn btn-custom">Profile</a>
                <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                <a href="login.php" class="btn btn-danger">login</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
