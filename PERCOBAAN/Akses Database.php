<!DOCTYPE html>
<html>
    <body>   
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

    // Select Database
    $dbname = "myDB";
    mysqli_select_db($conn, $dbname);

    $sql = "SELECT kode, negara, champion FROM liga";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        echo "<table border='1' align='center'>";
        echo "<tr><th>Kode</th><th>Negara</th><th>Champion</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td align='center'>". $row["kode"]. "</td><td align='center'>" . $row["negara"]. "</td><td align='center'>" . $row["champion"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    mysqli_close($conn);
    ?>
    </body>
</html>