<?php

$koneksi = new mysqli("localhost", "root", "", "db_eksperimen");

$pesan = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // MITIGASI: Menggunakan Prepared Statements
    // Struktur query disiapkan terlebih dahulu (menggunakan tanda ?)
    $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    
    // Bind parameter (mengisi tanda ? dengan data. "ss" berarti string & string)
    $stmt->bind_param("ss", $username, $password);
    
    // Eksekusi query
    $stmt->execute();
    
    // Ambil hasil
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pesan = "<div style='color: green;'>Login Berhasil!</div>";
    } else {
        $pesan = "<div style='color: red;'>Login Gagal! Serangan SQL Injection dihentikan.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eksperimen SQL Injection - Aman</title>
</head>
<body>
    <h2>Form Login (Versi Aman - Prepared Statements)</h2>
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