<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

// Create conn
$conn = mysqli_connect($servername, $username, $password);

// Check conn
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// memilih database yang akan digunakan
mysqli_select_db($conn, $dbname);

// Insert data into table
$sql = "INSERT INTO liga (kode, negara, champion) VALUES
        ('Jer', 'Jerman', '4'),
        ('Spa', 'Spanyol', '3'),
        ('Eng', 'English', '3')";

if (mysqli_query($conn, $sql)) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>