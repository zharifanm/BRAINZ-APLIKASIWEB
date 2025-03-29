<?php
include 'config.php';

$host = "localhost"; // Ganti dengan server Anda
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "brainz"; // Nama database

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}

// Ambil data dari form
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];

// Handle file upload
$profilePhoto = '';
if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == 0) {
    $targetDir = "uploads/"; // Directory to save uploaded files
    $profilePhoto = $targetDir . basename($_FILES['profilePhoto']['name']);
    
    // Move the uploaded file to the target directory
    if (!move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $profilePhoto)) {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }
}

// Siapkan dan bind
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, profile_photo) VALUES (:firstName, :lastName, :email, :profilePhoto)");
$stmt->bindParam(':firstName', $firstName);
$stmt->bindParam(':lastName', $lastName);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':profilePhoto', $profilePhoto);

// Eksekusi statement
if ($stmt->execute()) {
    echo "Data berhasil disimpan!";
} else {
    echo "Error: " . $stmt->error;
}

// Fungsi untuk update foto profil
function updateProfilePhoto($email, $newPhotoPath) {
    global $conn;
    
    // Query untuk mengupdate foto profil berdasarkan email
    $sql = "UPDATE users SET profile_photo = :newPhoto WHERE email = :email";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':newPhoto', $newPhotoPath);
    $stmt->bindParam(':email', $email);

    if($stmt->execute()) {
        echo "Foto profil berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui foto profil.";
    }
}

// Contoh pemanggilan fungsi untuk memperbarui foto profil 
if ($profilePhoto && !empty($email)) {
    updateProfilePhoto($email, $profilePhoto);
}

// Tutup koneksi
$conn=null;
?>

