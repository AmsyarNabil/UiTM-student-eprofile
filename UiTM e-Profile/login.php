<?php
// Mula sesi
session_start();

// Sertakan fail konfigurasi
include 'config.php'; // Pastikan fail config.php ada dan sambungan database betul

// Inisialisasi mesej ralat
$error = '';

// Semak jika borang dihantar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dapatkan dan tapis input borang
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';

    // Semak input kosong
    if (empty($username) || empty($password)) {
        $error = "Sila isi kedua-dua ruangan.";
    } else {
        // Sediakan pertanyaan SQL
        $query = "SELECT * FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            // Semak jika pengguna wujud
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Sahkan kata laluan
                if (password_verify($password, $user['passwords'])) { // Gunakan 'passwords' sesuai dengan nama lajur jadual
                    // Tetapkan pembolehubah sesi
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];

                    // Arahkan ke halaman dashboard.php
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Kata laluan salah.";
                }
            } else {
                $error = "Nama pengguna tidak dijumpai.";
            }

            $stmt->close();
        } else {
            $error = "Ralat pangkalan data. Sila cuba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UiTM e-Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }

        h3 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            color: #0044cc;
        }

        .btn-primary {
            background-color: #0044cc;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 50px;
        }

        .btn-primary:hover {
            background-color: #003399;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .text-center a {
            color: #0044cc;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h3>UiTM e-Profile Login</h3>

        <!-- Paparkan mesej ralat -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan nama pengguna anda" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata laluan anda" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
