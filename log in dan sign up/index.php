<?php
// Start session
session_start();

// Include database connection
require_once 'config.php';

// Check if user is already logged in
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Educational Platform</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      min-height: 100vh;
      background: linear-gradient(to bottom, #e9d5ff, #d8b4fe, white);
      position: relative;
      overflow-x: hidden;
    }
    
    .wave {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 250px;
      background-color: white;
      border-radius: 50% 50% 0 0;
      z-index: -1;
    }
    
    nav {
      background-color: white;
      border-radius: 50px;
      margin: 16px;
      padding: 16px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .logo {
      color: #7e22ce;
      font-size: 24px;
      font-weight: bold;
    }
    
    .nav-links {
      display: flex;
      gap: 32px;
    }
    
    .nav-links a {
      color: #7e22ce;
      text-decoration: none;
      transition: color 0.3s;
    }
    
    .nav-links a:hover {
      color: #a855f7;
    }
    
    .auth-links {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    
    .auth-links a:first-child {
      color: #7e22ce;
      text-decoration: none;
    }
    
    .auth-links a:last-child {
      background-color: #a855f7;
      color: white;
      padding: 8px 16px;
      border-radius: 50px;
      text-decoration: none;
      transition: background-color 0.3s;
    }
    
    .auth-links a:last-child:hover {
      background-color: #9333ea;
    }
    
    main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 64px 16px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    @media (min-width: 768px) {
      main {
        flex-direction: row;
        align-items: center;
      }
    }
    
    .content {
      margin-bottom: 32px;
    }
    
    @media (min-width: 768px) {
      .content {
        width: 50%;
        margin-bottom: 0;
      }
      
      .image-container {
        width: 50%;
        display: flex;
        justify-content: center;
      }
    }
    
    h1 {
      font-size: 36px;
      color: #6b21a8;
      margin-bottom: 16px;
    }
    
    @media (min-width: 768px) {
      h1 {
        font-size: 48px;
      }
    }
    
    .content p {
      color: #581c87;
      margin-bottom: 32px;
      max-width: 400px;
    }
    
    .cta-button {
      background-color: white;
      color: #7e22ce;
      padding: 12px 32px;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s;
    }
    
    .cta-button:hover {
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .books-image {
      max-width: 100%;
      height: auto;
    }
    
    /* Modal styles */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 50;
      <?php echo !isset($_GET['login']) && !isset($_GET['signup']) ? 'display: none;' : ''; ?>
    }
    
    .modal {
      background-color: white;
      border-radius: 24px;
      padding: 32px;
      max-width: 400px;
      width: 100%;
      margin: 0 16px;
    }
    
    .modal-header {
      text-align: center;
      margin-bottom: 24px;
    }
    
    .modal-header h2 {
      font-size: 24px;
      color: #a855f7;
      margin-bottom: 8px;
    }
    
    .modal-header p {
      color: #6b7280;
    }
    
    .form-group {
      margin-bottom: 16px;
    }
    
    .form-control {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 16px;
    }
    
    .form-control:focus {
      outline: none;
      border-color: #a855f7;
      box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
    }
    
    .divider {
      text-align: center;
      color: #6b7280;
      margin: 16px 0;
    }
    
    .social-login {
      display: flex;
      justify-content: center;
      margin-bottom: 16px;
    }
    
    .google-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 1px solid #d1d5db;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }
    
    .login-btn {
      width: 100%;
      background-color: #a855f7;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 50px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    
    .login-btn:hover {
      background-color: #9333ea;
    }
    
    .signup-link {
      text-align: center;
      margin-top: 24px;
      color: #6b7280;
    }
    
    .signup-link a {
      color: #7e22ce;
      font-weight: 500;
      text-decoration: none;
      margin-left: 4px;
    }
    
    .error-message {
      color: #ef4444;
      margin-bottom: 16px;
      text-align: center;
    }
    
    .success-message {
      color: #10b981;
      margin-bottom: 16px;
      text-align: center;
    }
    
    @media (max-width: 768px) {
      .nav-links {
        display: none;
      }
    }
  </style>
</head>
<body>
  <!-- Wave shape at bottom -->
  <div class="wave"></div>
  
  <!-- Navigation -->
  <nav>
    <div class="logo">LOGO</div>
    
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="#">About Us</a>
      <a href="#">Blog</a>
    </div>
    
    <div class="auth-links">
      <?php if ($loggedIn): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Log Out</a>
      <?php else: ?>
        <a href="?login">Log In</a>
        <a href="?signup">Sign Up</a>
      <?php endif; ?>
    </div>
  </nav>
  
  <!-- Main Content -->
  <main>
    <div class="content">
      <h1>Selamat Datang</h1>
      <p>Tempat di mana belajar jadi lebih menyenangkan dan penuh inspirasi. Mari jelajahi bersama!</p>
      <?php if ($loggedIn): ?>
        <a href="dashboard.php" class="cta-button">DASHBOARD</a>
      <?php else: ?>
        <a href="?signup" class="cta-button">MULAI SEKARANG</a>
      <?php endif; ?>
    </div>
    
    <div class="image-container">
      <img src="https://via.placeholder.com/400x300/f3e8ff/6b21a8?text=Books" alt="Colorful books" class="books-image">
    </div>
  </main>
  
  <!-- Login Modal -->
  <?php if (isset($_GET['login'])): ?>
  <div class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h2>Selamat Datang Kembali</h2>
        <p>Kindly fill in your login details to proceed</p>
      </div>
      
      <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
          <?php 
            $error = $_GET['error'];
            if ($error === 'empty') {
              echo "Please fill in all fields";
            } elseif ($error === 'invalid') {
              echo "Invalid email or password";
            }
          ?>
        </div>
      <?php endif; ?>
      
      <form action="login_process.php" method="POST">
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        
        <div class="divider">or Log in with</div>
        
        <div class="social-login">
          <button type="button" class="google-btn">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google logo" width="20" height="20">
          </button>
        </div>
        
        <button type="submit" class="login-btn">LOGIN</button>
      </form>
      
      <div class="signup-link">
        Don't have an account yet?<a href="?signup">Sign Up</a>
      </div>
    </div>
  </div>
  <?php endif; ?>
  
  <!-- Signup Modal -->
  <?php if (isset($_GET['signup'])): ?>
  <div class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h2>Create an Account</h2>
        <p>Join our community today</p>
      </div>
      
      <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
          <?php 
            $error = $_GET['error'];
            if ($error === 'empty') {
              echo "Please fill in all fields";
            } elseif ($error === 'email') {
              echo "Email already exists";
            } elseif ($error === 'password') {
              echo "Passwords do not match";
            }
          ?>
        </div>
      <?php endif; ?>
      
      <form action="signup_process.php" method="POST">
        <div class="form-group">
          <input type="text" name="name" class="form-control" placeholder="Full Name" required>
        </div>
        
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        
        <div class="form-group">
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
        </div>
        
        <button type="submit" class="login-btn">SIGN UP</button>
      </form>
      
      <div class="signup-link">
        Already have an account?<a href="?login">Log In</a>
      </div>
    </div>
  </div>
  <?php endif; ?>
  
  <script>
    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
      const modalOverlay = document.querySelector('.modal-overlay');
      if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
          if (e.target === modalOverlay) {
            window.location.href = 'index.php';
          }
        });
      }
    });
  </script>
</body>
</html>

