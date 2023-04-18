<?php
// Membuat koneksi ke server MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Mengecek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Menjalankan perintah SQL untuk membuat tabel
$sql = "CREATE TABLE liga (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
kode VARCHAR(3) NOT NULL,
negara VARCHAR(30) NOT NULL,
champion INT(3)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table liga created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Menutup koneksi ke server MySQL
mysqli_close($conn);
?>