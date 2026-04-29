<?php

$koneksi = new mysqli("localhost", "root", "", "db_eksperimen");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$pesan = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // VULNERABILITY: Input langsung digabung ke query tanpa filter
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    // eksekusi query
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        $pesan = "<div style='color: green;'>Login Berhasil! Selamat datang, " . htmlspecialchars($username) . ".</div>";
    } else {
        $pesan = "<div style='color: red;'>Login Gagal! Username atau password salah.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eksperimen SQL Injection - Rentan</title>
</head>
<body>
    <h2>Form Login (Versi Rentan)</h2>
    <?php echo $pesan; ?>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>