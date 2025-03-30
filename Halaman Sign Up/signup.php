<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username   = "root";    // Sesuaikan dengan user MySQL Anda
$password   = "";        // Sesuaikan dengan password MySQL Anda
$dbname     = "brainz_db";

// Buat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
// Pastikan name di form (misalnya <input type="text" name="name">) sesuai dengan di sini
$full_name = $_POST['name'];
$email     = $_POST['email'];
// Hash password
$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Cek apakah email sudah terdaftar
$checkEmail = "SELECT email FROM users WHERE email='$email'";
$result = $conn->query($checkEmail);

if ($result->num_rows > 0) {
    echo "<script>
            alert('Email sudah terdaftar! Gunakan email lain.');
            window.location.href='signup.php';
          </script>";
} else {
    // Simpan data ke database
    // Kolom untuk nama adalah full_name sesuai struktur tabel di gambar
    $sql = "INSERT INTO users (full_name, email, password) 
            VALUES ('$full_name', '$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href='login.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
