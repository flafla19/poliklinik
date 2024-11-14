<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    // Pengecekan untuk menghindari error Undefined array key
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    $user = mysqli_fetch_assoc($result);

    // Cek apakah user ada dan password benar
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>Username atau password salah!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <h2 class="text-center">Login</h2>
                <form method="POST">
    <div class="form-group mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
    </div>
    <div class="form-group mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
</form>
                <hr>
                <div class="text-center">
                    <p>Belum punya akun? <a href="register.php" class="btn btn-link">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
