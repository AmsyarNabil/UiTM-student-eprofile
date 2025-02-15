<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM profile WHERE user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $profile = $result->fetch_assoc();
    } else {
        $error = "Maklumat profil tidak dijumpai.";
    }

    $stmt->close();
} else {
    $error = "Ralat dalam sambungan pangkalan data.";
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - UiTM e-Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: white;
            background: linear-gradient(to right, #2c3e50, #34495e);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgb(0, 0, 0);
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .hero-section {
            background-image: url('https://images.unsplash.com/photo-1593642634341-250b6f2c0c61');
            background-size: cover;
            height: 400px;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .info-card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            background-color: rgba(0, 0, 0, 0.6);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: scale(1.05);
        }

        .info-card-header {
            background-color: #ff5733;
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            font-weight: bold;
        }

        .info-card-body {
            padding: 20px;
            background-color: rgb(255, 255, 255);
        }

        .btn-custom {
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #e43b2e;
        }

        .container-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .container-buttons a {
            text-decoration: none;
        }

        .container {
            margin-top: 40px;
            z-index: 1;
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
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to UiTM e-profile, AMSYAR NABIL!</h1>
    </div>

    <!-- Profile Info & Stats -->
    <div class="container">
        <div class="row">
            <!-- Profile Info -->
            <div class="col-md-6">
                <div class="card info-card">
                    <div class="info-card-header">Profile Information</div>
                    <div class="info-card-body">
                        <p><strong>Name:</strong> AMSYAR NABIL BIN AZHAR</p>
                        <p><strong>Email:</strong> azharamsyarnabil@gmail.com</p>
                        <p><strong>Phone no:</strong> 011-37484552</p>
                        <p><strong>Address:</strong> N0. 17, JALAN BERLIAN 6, TAMAN RENGGAM JAYA, 86200 SIMPANG RENGGAM, JOHOR DARUL TA'ZIM</p>
                        <a href="profile.php" class="btn btn-custom w-100">Update Information</a>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="col-md-6">
                <div class="card info-card">
                    <div class="info-card-header">Statistics</div>
                    <div class="info-card-body">
                        <div class="card-stats">
                            <div class="stat">
                                <p>Latest Activity</p>
                                <h3>5</h3>
                            </div>
                            <div class="stat">
                                <p>Notification</p>
                                <h3>3</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




