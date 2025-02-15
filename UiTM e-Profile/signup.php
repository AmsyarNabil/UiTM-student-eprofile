<?php
// Sertakan fail konfigurasi
include 'config.php'; // Pastikan fail config.php disesuaikan dengan sambungan pangkalan data anda

// Inisialisasi mesej ralat dan kejayaan
$error = '';
$success = '';

// Semak jika borang dihantar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dapatkan dan tapis input
    $username = isset($_POST['username']) ? htmlspecialchars(trim($_POST['username'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : '';
    $confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars(trim($_POST['confirm_password'])) : '';

    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua ruangan diperlukan.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format emel tidak sah.";
    } elseif ($password !== $confirm_password) {
        $error = "Kata laluan tidak sepadan.";
    } else {
        // Semak jika nama pengguna atau emel sudah wujud
        $query = "SELECT * FROM users WHERE username = ? OR email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Nama pengguna atau emel sudah wujud.";
            } else {
                // Hash kata laluan sebelum menyimpan
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Masukkan pengguna baharu ke dalam pangkalan data
                $query = "INSERT INTO users (username, email, passwords) VALUES (?, ?, ?)";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("sss", $username, $email, $hashed_password);
                    if ($stmt->execute()) {
                        $success = "Akaun berjaya didaftarkan. Anda boleh <a href='login.php'>log masuk</a> sekarang.";
                    } else {
                        $error = "Ralat semasa mendaftar. Sila cuba lagi.";
                    }
                } else {
                    $error = "Ralat pangkalan data semasa memasukkan pengguna.";
                }
            }
            $stmt->close();
        } else {
            $error = "Ralat pangkalan data semasa menyemak pengguna.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - UiTM e-Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .signup-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #0044cc;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003399;
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <h3 class="text-center mb-4">Sign Up</h3>

        <!-- Paparkan mesej ralat -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Paparkan mesej kejayaan -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Borang Daftar -->
        <form method="POST" action="signup.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan nama pengguna" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan emel" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata laluan" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Sahkan kata laluan" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>

        <p class="text-center mt-3">
            Sudah mempunyai akaun? <a href="login.php">Log Masuk</a>
        </p>
    </div>
</body>

</html>
