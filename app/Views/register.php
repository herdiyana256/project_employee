<?php
// views/register.php

// Koneksi ke database
$conn = mysqli_connect("localhost", "username", "password", "database");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: ". mysqli_connect_error());
}

// Proses registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validasi input
    if (empty($nama) || empty($email) || empty($password)) {
        $error = "Mohon isi semua field!";
    } else {
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert data ke database
        $query = "INSERT INTO employees (nama, email, password) VALUES ('$nama', '$email', '$password_hash')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $success = "Registrasi berhasil!";
        } else {
            $error = "Registrasi gagal: ". mysqli_error($conn);
        }
    }
}

// Form registrasi
?>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" value="Register">
</form>

<?php
// Tampilkan pesan error atau success
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
} elseif (isset($success)) {
    echo "<p style='color: green;'>$success</p>";
}
?>