<?php
include 'koneksi.php';
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi
    $checkUser = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($checkUser) > 0) {
        echo "<div class='alert alert-danger'>Username sudah terdaftar!</div>";
    } elseif ($password !== $confirm_password) {
        echo "<div class='alert alert-danger'>Password tidak cocok!</div>";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user (username, password) VALUES ('$username', '$hashedPassword')";
        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success'>Registrasi berhasil!</div>";
            header("Location: login.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST">
            <div class="form-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
        </form>
        <hr>
        <div class="text-center">
            <p>Sudah punya akun? <a href="login.php" class="btn btn-link">Login</a></p>
        </div>
    </div>
</body>
</html>
