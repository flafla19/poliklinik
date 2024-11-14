<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Tambah data periksa
if (isset($_POST['add'])) {
    $id_dokter = $_POST['id_dokter'];
    $id_pasien = $_POST['id_pasien'];
    $obat = $_POST['obat'];
    $diagnosis = $_POST['diagnosis'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    mysqli_query($conn, "INSERT INTO periksa (id_dokter, id_pasien, obat, diagnosis, tanggal_periksa) VALUES ('$id_dokter', '$id_pasien', '$obat', '$diagnosis', '$tanggal_periksa')");
    header("Location: periksa.php");
}

// Edit data periksa
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_dokter = $_POST['id_dokter'];
    $id_pasien = $_POST['id_pasien'];
    $obat = $_POST['obat'];
    $diagnosis = $_POST['diagnosis'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    mysqli_query($conn, "UPDATE periksa SET id_dokter='$id_dokter', id_pasien='$id_pasien', obat='$obat', diagnosis='$diagnosis', tanggal_periksa='$tanggal_periksa' WHERE id=$id");
    header("Location: periksa.php");
}

// Hapus data periksa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM periksa WHERE id=$id");
    header("Location: periksa.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Periksa</title>
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
    <div class="container mt-4">
        <h2>Periksa</h2>
        <form method="POST">
            <input type="hidden" name="id" id="id">
            <div class="form-group mb-2">
                <select name="id_dokter" id="id_dokter" class="form-control" required>
                    <option value="">Pilih Dokter</option>
                    <?php
                    $dokter = mysqli_query($conn, "SELECT * FROM dokter");
                    while ($row = mysqli_fetch_assoc($dokter)) {
                        echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <select name="id_pasien" id="id_pasien" class="form-control" required>
                    <option value="">Pilih Pasien</option>
                    <?php
                    $pasien = mysqli_query($conn, "SELECT * FROM pasien");
                    while ($row = mysqli_fetch_assoc($pasien)) {
                        echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <input type="text" name="obat" id="obat" class="form-control" placeholder="Obat" required>
            </div>
            <div class="form-group mb-2">
                <textarea name="diagnosis" id="diagnosis" class="form-control" placeholder="Diagnosis" required></textarea>
            </div>
            <div class="form-group mb-2">
                <input type="date" name="tanggal_periksa" id="tanggal_periksa" class="form-control" placeholder="Tanggal Periksa" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Tambah</button>
            <button type="submit" name="update" class="btn btn-success">Ubah</button>
        </form>
        
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Dokter</th>
                    <th>Pasien</th>
                    <th>Obat</th>
                    <th>Diagnosis</th>
                    <th>Tanggal Periksa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT periksa.*, dokter.nama AS nama_dokter, pasien.nama AS nama_pasien FROM periksa 
                JOIN dokter ON periksa.id_dokter = dokter.id 
                JOIN pasien ON periksa.id_pasien = pasien.id");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['nama_dokter']}</td>
                        <td>{$row['nama_pasien']}</td>
                        <td>{$row['obat']}</td>
                        <td>{$row['diagnosis']}</td>
                        <td>{$row['tanggal_periksa']}</td>
                        <td>
                            <button onclick=\"editData({$row['id']}, '{$row['id_dokter']}', '{$row['id_pasien']}', '{$row['obat']}', '{$row['diagnosis']}', '{$row['tanggal_periksa']}')\" class='btn btn-warning btn-sm'>Ubah</button>
                            <a href='?delete={$row['id']}' class='btn btn-danger btn-sm'>Hapus</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
    function editData(id, id_dokter, id_pasien, obat, diagnosis, tanggal_periksa) {
        document.getElementById('id').value = id;
        document.getElementById('id_dokter').value = id_dokter;
        document.getElementById('id_pasien').value = id_pasien;
        document.getElementById('obat').value = obat;
        document.getElementById('diagnosis').value = diagnosis;
        document.getElementById('tanggal_periksa').value = tanggal_periksa;
    }
    </script>
</body>
</html>
