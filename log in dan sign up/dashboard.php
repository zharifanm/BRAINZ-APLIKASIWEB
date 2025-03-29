<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?login");
    exit();
}

// Include database connection
require_once 'config.php';

// Get user data
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Educational Platform</title>
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
      padding: 32px 16px;
    }
    
    .dashboard-header {
      margin-bottom: 32px;
    }
    
    .dashboard-header h1 {
      font-size: 32px;
      color: #6b21a8;
      margin-bottom: 8px;
    }
    
    .dashboard-header p {
      color: #581c87;
    }
    
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 24px;
    }
    
    .card {
      background-color: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .card h2 {
      font-size: 20px;
      color: #7e22ce;
      margin-bottom: 16px;
    }
    
    .card p {
      color: #6b7280;
      margin-bottom: 16px;
    }
    
    .card-link {
      display: inline-block;
      color: #a855f7;
      font-weight: 500;
      text-decoration: none;
    }
    
    .card-link:hover {
      text-decoration: underline;
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
      <a href="dashboard.php">Dashboard</a>
      <a href="logout.php">Log Out</a>
    </div>
  </nav>
  
  <!-- Main Content -->
  <main>
    <div class="dashboard-header">
      <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
      <p>Here's what you can explore today</p>
    </div>
    
    <div class="dashboard-cards">
      <div class="card">
        <h2>My Courses</h2>
        <p>Access your enrolled courses and continue learning at your own pace.</p>
        <a href="#" class="card-link">View Courses</a>
      </div>
      
      <div class="card">
        <h2>Assignments</h2>
        <p>Check your pending assignments and submit your work.</p>
        <a href="#" class="card-link">View Assignments</a>
      </div>
      
      <div class="card">
        <h2>Progress</h2>
        <p>Track your learning progress and achievements.</p>
        <a href="#" class="card-link">View Progress</a>
      </div>
      
      <div class="card">
        <h2>Community</h2>
        <p>Connect with other learners and share your experiences.</p>
        <a href="#" class="card-link">Join Discussion</a>
      </div>
    </div>
  </main>
</body>
</html>

