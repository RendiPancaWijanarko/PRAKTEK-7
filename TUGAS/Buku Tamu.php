<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PRAKTIKUM7_NOMOR1";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Membuat tabel buku_tamu
$sql = "CREATE TABLE buku_tamu (
    ID_BT INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NAMA VARCHAR(200) NOT NULL,
    EMAIL VARCHAR(50) NOT NULL,
    ISI TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabel buku_tamu berhasil dibuat";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>