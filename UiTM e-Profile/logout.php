<?php
// Mulakan sesi
session_start(); // Mulakan atau sambung sesi semasa

// Kosongkan semua data sesi
$_SESSION = []; // Kosongkan semua pembolehubah sesi

// Hapuskan kuki sesi jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params(); // Dapatkan parameter kuki sesi
    setcookie(
        session_name(), // Nama sesi
        '', // Kosongkan kandungan kuki
        time() - 3600, // Tetapkan masa tamat kuki kepada masa lampau
        $params["path"], // Tetapkan laluan kuki
        $params["domain"], // Tetapkan domain kuki
        $params["secure"], // Hanya kuki yang selamat
        $params["httponly"] // Akses kuki hanya melalui HTTP
    );
}

// Hancurkan sesi
session_destroy(); // Hapuskan sesi sepenuhnya

// Arahkan ke halaman log masuk selepas log keluar
header("Location: login.php"); // Arahkan pengguna ke login.php
exit(); // Pastikan tiada kod lain dijalankan selepas ini
?>
