<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Tambah data dokter
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $query = "INSERT INTO dokter (nama, alamat, telp) VALUES ('$nama', '$alamat', '$telp')";
    mysqli_query($conn, $query);
    header("Location: dokter.php");
}

// Edit data dokter
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    mysqli_query($conn, "UPDATE dokter SET nama='$nama', alamat='$alamat', telp='$telp' WHERE id=$id");
    header("Location: dokter.php");
}

// Hapus data dokter
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM dokter WHERE id=$id");
    header("Location: dokter.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dokter</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dokter.php">Data Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pasien.php">Data Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="periksa.php">Data Periksa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Dokter</h2>
        <form method="POST" class="mb-3">
            <input type="hidden" name="id" id="id">
            <div class="form-group mb-2">
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Dokter" required>
            </div>
            <div class="form-group mb-2">
                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" required>
            </div>
            <div class="form-group mb-2">
                <input type="text" name="telp" id="telp" class="form-control" placeholder="Telepon" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Tambah</button>
            <button type="submit" name="update" class="btn btn-success">Ubah</button>
        </form>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM dokter");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['nama']}</td>
                        <td>{$row['alamat']}</td>
                        <td>{$row['telp']}</td>
                        <td>
                            <button onclick=\"editData({$row['id']}, '{$row['nama']}', '{$row['alamat']}', '{$row['telp']}')\" class='btn btn-warning btn-sm'>Ubah</button>
                            <a href='?delete={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function editData(id, nama, alamat, telp) {
        document.getElementById('id').value = id;
        document.getElementById('nama').value = nama;
        document.getElementById('alamat').value = alamat;
        document.getElementById('telp').value = telp;
    }
    </script>
</body>
</html>
