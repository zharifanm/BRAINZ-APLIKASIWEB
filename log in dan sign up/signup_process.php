<?php
// Start session
session_start();

// Include database connection
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: index.php?signup&error=empty");
        exit();
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: index.php?signup&error=password");
        exit();
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Email already exists
        header("Location: index.php?signup&error=email");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // Registration successful, create session
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Registration failed
        header("Location: index.php?signup&error=failed");
        exit();
    }
    
    $stmt->close();
} else {
    // If not POST request, redirect to signup page
    header("Location: index.php?signup");
    exit();
}

$conn->close();
?>

