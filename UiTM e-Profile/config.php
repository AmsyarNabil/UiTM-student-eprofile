<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uitmlogin"; // Tukar nama pangkalan data ke 'uitmlogin'

// Buat sambungan
$conn = new mysqli($servername, $username, $password, $dbname);

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tetapkan set karakter
$conn->set_charset("utf8mb4");
?>
