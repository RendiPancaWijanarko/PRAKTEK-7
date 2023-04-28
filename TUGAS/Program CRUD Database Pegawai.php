<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pegawai";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi berhasil terhubung";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manajemen Data Pegawai</title>
    <style>
        /* Style untuk heading */
        h1 {
            font-size: 48px;
            font-weight: bold;
            text-align: center;
            margin-top: 50px;
            color: #333333;
        }

        h2 {
            font-size: 32px;
            font-weight: bold;
            margin-top: 30px;
            color: #333333;
        }

        /* Style untuk form input */
        form {
            margin: 30px 0;
        }

        label {
            display: inline-block;
            width: 150px;
            margin-right: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #333333;
        }

        input[type='text'],
        input[type='number'] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            color: #333333;
        }

        input[type='submit'] {
            padding: 8px 16px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            background-color: #1abc9c;
            color: #ffffff;
            cursor: pointer;
        }

        input[type='submit']:hover {
            background-color: #148f77;
        }

        /* Style untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #1abc9c;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
        }

        /* Style untuk aksi */
        form[action='edit.php'] {
            display: inline-block;
            margin-right: 10px;
        }

        form[action='delete.php'] {
            display: inline-block;
        }

        form[action='delete.php'] input[type='submit'] {
            background-color: #e74c3c;
        }

        form[action='delete.php'] input[type='submit']:hover {
            background-color: #c0392b;
        }
    </style>

</head>

<body>
    <h1>Manajemen Data Pegawai</h1>
    <h2>Input Data Pegawai</h2>
    <form method="POST">
        <label for="nama_pegawai">Nama Pegawai:</label>
        <input type="text" name="nama_pegawai" required><br><br>
        <label for="jabatan">Jabatan:</label>
        <input type="text" name="jabatan" required><br><br>
        <label for="gaji">Gaji:</label>
        <input type="number" name="gaji" required><br><br>
        <label for="id_divisi">ID Divisi:</label>
        <input type="number" name="id_divisi" required><br><br>
        <input type="submit" name="submit" value="Tambah Data">
    </form>
    <br>
    <h2>Daftar Pegawai</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID Pegawai</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Gaji</th>
                <th>ID Divisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data pegawai
            $sql = "SELECT * FROM pegawai";
            $stmt = $conn->query($sql);
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $row['id_pegawai'] . "</td>";
                echo "<td>" . $row['nama_pegawai'] . "</td>";
                echo "<td>" . $row['jabatan'] . "</td>";
                echo "<td>" . $row['gaji'] . "</td>";
                echo "<td>" . $row['id_divisi'] . "</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='id' value='" . $row['id_pegawai'] . "'>";
                echo "<input type='submit' name='delete' value='Hapus'>";
                echo "<input type='submit' name='update' value='Ubah'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    // Memproses input data pegawai
    if (isset($_POST['submit'])) {
        $nama_pegawai = $_POST['nama_pegawai'];
        $jabatan = $_POST['jabatan'];
        $gaji = $_POST['gaji'];
        $id_divisi = $_POST['id_divisi'];

        try {
            $sql = "INSERT INTO pegawai (nama_pegawai, jabatan, gaji, id_divisi) VALUES (:nama_pegawai, :jabatan, :gaji, :id_divisi)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nama_pegawai', $nama_pegawai);
            $stmt->bindParam(':jabatan', $jabatan);
            $stmt->bindParam(':gaji', $gaji);
            $stmt->bindParam(':id_divisi', $id_divisi);
            $stmt->execute();
            echo "<script>alert('Data pegawai berhasil ditambahkan');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Menghapus data pegawai
    if (isset($_POST['delete'])) {
        $id_pegawai = $_POST['id'];
        try {
            $sql = "DELETE FROM pegawai WHERE id_pegawai=:id_pegawai";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pegawai', $id_pegawai);
            $stmt->execute();
            echo "<script>alert('Data pegawai berhasil dihapus');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Menampilkan data pegawai yang akan diubah pada form
    if (isset($_POST['update'])) {
        $id_pegawai = $_POST['id'];
        try {
            $sql = "SELECT * FROM pegawai WHERE id_pegawai=:id_pegawai";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pegawai', $id_pegawai);
            $stmt->execute();
            $row = $stmt->fetch();
            $id_pegawai = $row['id_pegawai'];
            $nama_pegawai = $row['nama_pegawai'];
            $jabatan = $row['jabatan'];
            $gaji = $row['gaji'];
            $id_divisi = $row['id_divisi'];

            echo "<h2>Ubah Data Pegawai</h2>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='id_pegawai' value='$id_pegawai'>";
            echo "<label for='nama_pegawai'>Nama Pegawai:</label>";
            echo "<input type='text' name='nama_pegawai' value='$nama_pegawai' required><br><br>";
            echo "<label for='jabatan'>Jabatan:</label>";
            echo "<input type='text' name='jabatan' value='$jabatan' required><br><br>";
            echo "<label for='gaji'>Gaji:</label>";
            echo "<input type='number' name='gaji' value='$gaji' required><br><br>";
            echo "<label for='id_divisi'>ID Divisi:</label>";
            echo "<input type='number' name='id_divisi' value='$id_divisi' required><br><br>";
            echo "<input type='submit' name='update_data' value='Ubah Data'>";
            echo "</form>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Menampilkan data pegawai yang akan diubah pada form
    if (isset($_POST['update'])) {
        $id_pegawai = $_POST['id'];
        try {
            $sql = "SELECT * FROM pegawai WHERE id_pegawai=:id_pegawai";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pegawai', $id_pegawai);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Menampilkan form untuk mengubah data pegawai
    if (isset($result)) {
    ?>
        <h2>Ubah Data Pegawai</h2>
        <form method="POST">
            <label for="nama_pegawai">Nama Pegawai:</label>
            <input type="text" name="nama_pegawai" value="<?php echo $result['nama_pegawai']; ?>" required><br><br>
            <label for="jabatan">Jabatan:</label>
            <input type="text" name="jabatan" value="<?php echo $result['jabatan']; ?>" required><br><br>
            <label for="gaji">Gaji:</label>
            <input type="number" name="gaji" value="<?php echo $result['gaji']; ?>" required><br><br>
            <label for="id_divisi">ID Divisi:</label>
            <input type="number" name="id_divisi" value="<?php echo $result['id_divisi']; ?>" required><br><br>
            <input type="hidden" name="id" value="<?php echo $result['id_pegawai']; ?>">
            <input type="submit" name="update_data" value="Simpan Perubahan">
        </form>
    <?php
    }

    // Memproses input data pegawai yang diubah
    if (isset($_POST['update_data'])) {
        $id_pegawai = $_POST['id'];
        $nama_pegawai = $_POST['nama_pegawai'];
        $jabatan = $_POST['jabatan'];
        $gaji = $_POST['gaji'];
        $id_divisi = $_POST['id_divisi'];

        try {
            $sql = "UPDATE pegawai SET nama_pegawai=:nama_pegawai, jabatan=:jabatan, gaji=:gaji, id_divisi=:id_divisi WHERE id_pegawai=:id_pegawai";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_pegawai', $id_pegawai);
            $stmt->bindParam(':nama_pegawai', $nama_pegawai);
            $stmt->bindParam(':jabatan', $jabatan);
            $stmt->bindParam(':gaji', $gaji);
            $stmt->bindParam(':id_divisi', $id_divisi);
            $stmt->execute();
            echo "<script>alert('Data pegawai berhasil diubah');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Mengambil data setelah button update
    if (isset($_POST['update'])) {
        $id_pegawai = $_POST['id'];
        $nama_pegawai = $_POST['nama_pegawai'];
        $jabatan = $_POST['jabatan'];
        $gaji = $_POST['gaji'];
        $id_divisi = $_POST['id_divisi'];

        try {
            $sql = "UPDATE pegawai SET nama_pegawai=:nama_pegawai, jabatan=:jabatan, gaji=:gaji, id_divisi=:id_divisi WHERE id_pegawai=:id_pegawai";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nama_pegawai', $nama_pegawai);
            $stmt->bindParam(':jabatan', $jabatan);
            $stmt->bindParam(':gaji', $gaji);
            $stmt->bindParam(':id_divisi', $id_divisi);
            $stmt->bindParam(':id_pegawai', $id_pegawai);
            $stmt->execute();
            echo "<script>alert('Data pegawai berhasil diubah');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
