<?php
$servername = "localhost";
$username = "root";
$password = "";

// Membuat koneksi ke MySQL
$conn = new mysqli($servername, $username, $password);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Membuat database "PRAKTIKUM7_NOMOR1"
$sql = "CREATE DATABASE PRAKTIKUM7_NOMOR1";
if ($conn->query($sql) === TRUE) {
    echo "Database berhasil dibuat";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>
