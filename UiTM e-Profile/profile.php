<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// User profile information
$userProfile = [
    "name" => "AMSYAR NABIL BIN AZHAR",
    "student_id" => "2024545221",
    "email" => "2024545221@student.uitm.edu.my",
    "address" => "No. 17, JALAN BERLIAN 6, TAMAN RENGGAM JAYA, 86200 SIMPANG RENGGAM, JOHOR DARUL TA'ZIM",
    "program" => "CDIM262",
    "campus" => "UiTM Machang",
    "faculty" => "College of Computing, Informatics and Mathematics",
    "photo" => "images/photo_2025-01-26_02-28-09.jpg"
];

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $targetDir = "images/";
        $targetFile = $targetDir . basename($_FILES['photo']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate image file
        $check = getimagesize($_FILES['photo']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $userProfile['photo'] = $targetFile;
                $_SESSION['user_photo'] = $targetFile; // Store in session to persist update
                $success = "Profile picture updated successfully!";
            } else {
                $error = "Error uploading the image.";
            }
        } else {
            $error = "Uploaded file is not a valid image.";
        }
    } else {
        $error = "No file selected or an error occurred.";
    }
}

// Load updated image from session if available
if (isset($_SESSION['user_photo'])) {
    $userProfile['photo'] = $_SESSION['user_photo'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #2c3e50, #34495e);
            color: white;
        }
        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .profile-card img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #3498db;
            color: white;
            font-size: 1.1rem;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="profile-card">
            <!-- Profile Picture -->
            <img src="<?php echo htmlspecialchars($userProfile['photo']); ?>" alt="Profile Picture">

            <!-- Profile Details -->
            <h1><?php echo htmlspecialchars($userProfile['name']); ?></h1>
            <p><strong>Student ID:</strong> <?php echo htmlspecialchars($userProfile['student_id']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userProfile['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($userProfile['address']); ?></p>
            <p><strong>Program:</strong> <?php echo htmlspecialchars($userProfile['program']); ?></p>
            <p><strong>Campus:</strong> <?php echo htmlspecialchars($userProfile['campus']); ?></p>
            <p><strong>Faculty:</strong> <?php echo htmlspecialchars($userProfile['faculty']); ?></p>

            <!-- Image Upload Form -->
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="photo" class="form-control my-3" required>
                <button type="submit" class="btn btn-custom">Change Profile Picture</button>
            </form>

            <!-- Success/Error Message -->
            <?php if (isset($success)): ?>
                <p class="text-success mt-3"> <?php echo htmlspecialchars($success); ?> </p>
            <?php elseif (isset($error)): ?>
                <p class="text-danger mt-3"> <?php echo htmlspecialchars($error); ?> </p>
            <?php endif; ?>

            <!-- Navigation Buttons -->
            <a href="home.php" class="btn btn-custom">Home</a>
            <a href="dashboard.php" class="btn btn-custom">Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
