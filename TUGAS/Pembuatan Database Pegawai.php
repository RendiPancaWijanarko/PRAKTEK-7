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

// Membuat database "pegawai"
$sql = "CREATE DATABASE pegawai";
if ($conn->query($sql) === TRUE) {
    echo "Database berhasil dibuat";
} else {
    echo "Error creating database: " . $conn->error;
}

// Memilih database "pegawai"
mysqli_select_db($conn, "pegawai");

// Membuat tabel "divisi"
$sql = "CREATE TABLE divisi (
    id_divisi INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_divisi VARCHAR(200) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabel divisi berhasil dibuat";
} else {
    echo "Error creating table: " . $conn->error;
}

// Membuat tabel "pegawai"
$sql = "CREATE TABLE pegawai (
    id_pegawai INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_pegawai VARCHAR(200) NOT NULL,
    jabatan VARCHAR(50) NOT NULL,
    gaji INT(10) UNSIGNED,
    id_divisi INT(10) UNSIGNED,
    FOREIGN KEY (id_divisi) REFERENCES divisi(id_divisi)
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabel pegawai berhasil dibuat";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>