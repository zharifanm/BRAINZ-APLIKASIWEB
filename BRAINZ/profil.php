<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brainz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data user Diana Dewi
$first_name = "Diana";
$sql = "SELECT * FROM users WHERE first_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $first_name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRAINZ - Student Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            background-color: #f5f5f5;
        }
        
        /* Sidebar styles */
        .sidebar {
            width: 120px;
            background-color: #f3e9f7;
            height: 100vh;
            padding: 20px 10px;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .logo-container {
            margin-bottom: 30px;
        }
        
        .logo {
            width: 60px;
            height: auto;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 12px 5px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }
        
        .nav-item:hover {
            background-color: #e6d7f0;
        }
        
        .nav-item i {
            color: #8e44ad;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .account-header {
            font-size: 12px;
            color: #666;
            margin: 20px 0 10px;
            font-weight: bold;
            width: 100%;
            text-align: center;
        }
        
        .notification-container {
            position: relative;
        }
        
        .notification {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff3b30;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
        }
        
        .footer-contact {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
            padding: 0 5px;
        }
        
        .footer-contact i {
            color: #8e44ad;
            margin-bottom: 5px;
        }
        
        .contact-text {
            color: #ff3b30;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }
        
        .contact-number {
            color: #666;
            font-size: 9px;
        }
        
        /* Main content styles */
        .main-content {
            margin-left: 120px;
            padding: 20px;
            width: calc(100% - 120px);
        }
        
        .header {
            background-color: #f3e9f7;
            padding: 15px 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .back-button {
            display: flex;
            align-items: center;
            color: #8e44ad;
            text-decoration: none;
            font-weight: bold;
        }
        
        .back-button i {
            margin-right: 5px;
        }
        
        .profile-info {
            display: flex;
            align-items: center;
        }
        
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            margin-left: 10px;
        }
        
        .profile-name {
            margin-left: 10px;
            font-weight: bold;
            color: #8e44ad;
        }
        
        .profile-subtitle {
            font-size: 10px;
            color: #888;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }
        
        .profile-card, .performance-card, .achievement-card, .notes-card {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .profile-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #f5f5f5;
            margin-right: 20px;
        }
        
        .profile-details {
            flex: 1;
        }
        
        .profile-title {
            font-size: 28px;
            color: #8e44ad;
            margin-bottom: 10px;
        }
        
        .profile-bio {
            color: #555;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        
        .edit-icon {
            color: #8e44ad;
            font-size: 20px;
        }
        
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        
        .tag {
            background-color: #8e44ad;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        
        .progress-container {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        
        .progress-bar {
            flex: 1;
            height: 8px;
            background-color: #eee;
            border-radius: 4px;
            margin: 0 10px;
        }
        
        .progress-fill {
            height: 100%;
            width: 60%;
            background: linear-gradient(to right, #8e44ad, #9b59b6);
            border-radius: 4px;
        }
        
        .progress-number {
            font-weight: bold;
            color: #8e44ad;
        }
        
        .section-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }
        
        .pie-chart {
            width: 200px;
            height: 200px;
        }
        
        .timeline {
            position: relative;
            margin-top: 30px;
            padding-left: 30px;
        }
        
        .timeline-line {
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #ddd;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-dot {
            position: absolute;
            left: -30px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #8e44ad;
            border: 3px solid white;
        }
        
        .timeline-dot.empty {
            background-color: white;
            border: 3px solid #8e44ad;
        }
        
        .timeline-content {
            background-color: #f3e9f7;
            border-radius: 10px;
            padding: 15px;
            min-height: 80px;
        }
        
        .notes-title {
            font-size: 24px;
            color: #8e44ad;
            margin-bottom: 15px;
        }
        
        .notes-subtitle {
            color: #555;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <img src="/placeholder.svg?height=60&width=60" alt="BRAINZ Logo" class="logo">
        </div>
        
        <a href="#" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Overview</span>
        </a>
        
        <a href="#" class="nav-item">
            <i class="fas fa-users"></i>
            <span>Match Mate</span>
        </a>
        
        <a href="#" class="nav-item">
            <i class="fas fa-gamepad"></i>
            <span>Game</span>
        </a>
        
        <a href="#" class="nav-item">
            <i class="fas fa-chart-line"></i>
            <span>Study Tracker</span>
        </a>
        
        <a href="#" class="nav-item notification-container">
            <i class="fas fa-comment-alt"></i>
            <span class="notification">2</span>
            <span>Chats</span>
        </a>
        
        <div class="account-header">ACCOUNT</div>
        
        <a href="#" class="nav-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        
        <a href="#" class="nav-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        
        <div class="footer-contact">
            <i class="fas fa-phone-alt"></i>
            <div class="contact-text">Laporkan Mate</div>
            <div class="contact-number">+62 123 456 7890</div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <a href="#" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Back</span>
            </a>
            
            <div class="profile-info">
                <i class="far fa-bell"></i>
                <div class="profile-pic"></div>
                <div>
                    <div class="profile-name"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></div>
                    <div class="profile-subtitle">LIHAT PROFIL</div>
                </div>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo" style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                        </div>
                        <div class="profile-details">
                            <h1 class="profile-title"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
                            <p class="profile-bio">
                                Haloo, aku <?php echo $user['first_name']; ?>! aku mahasiswa semester 4 
                                Program Studi Teknologi Informasi. Aku berminat 
                                dibidang sains dan teknologi, mari berteman dan 
                                belajar bersama!
                            </p>
                        </div>
                        <i class="fas fa-edit edit-icon"></i>
                    </div>
                    
                    <div class="tags">
                        <span class="tag">Teknologi</span>
                        <span class="tag">Big Data</span>
                        <span class="tag">Matematika</span>
                        <span class="tag">Teknologi</span>
                        <span class="tag">Teknologi</span>
                        <span class="tag">Teknologi</span>
                    </div>
                    
                    <div class="progress-container">
                        <span class="progress-number">8</span>
                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Achievement Card -->
                <div class="achievement-card">
                    <h2 class="section-title">Achivment</h2>
                    
                    <div class="timeline">
                        <div class="timeline-line"></div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content"></div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot empty"></div>
                            <div class="timeline-content"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="right-column">
                <!-- Performance Card -->
                <div class="performance-card">
                    <h2 class="section-title">Performa</h2>
                    
                    <div class="chart-container">
                        <svg class="pie-chart" viewBox="0 0 100 100">
                            <!-- Purple section (30%) -->
                            <path d="M50,50 L50,0 A50,50 0 0,1 93.3,75 Z" fill="#8e44ad"></path>
                            <!-- Pink section (15%) -->
                            <path d="M50,50 L93.3,75 A50,50 0 0,1 50,100 Z" fill="#e91e63"></path>
                            <!-- Magenta section (15%) -->
                            <path d="M50,50 L50,100 A50,50 0 0,1 6.7,75 Z" fill="#d81b60"></path>
                            <!-- Blue section (35%) -->
                            <path d="M50,50 L6.7,75 A50,50 0 0,1 50,0 Z" fill="#9c27b0"></path>
                            
                            <!-- Labels -->
                            <text x="75" y="30" font-size="5" fill="white">30%</text>
                            <text x="75" y="35" font-size="3" fill="white">Entertainment</text>
                            
                            <text x="75" y="75" font-size="5" fill="white">15%</text>
                            <text x="75" y="80" font-size="3" fill="white">Investment</text>
                            
                            <text x="30" y="85" font-size="5" fill="white">15%</text>
                            <text x="30" y="90" font-size="3" fill="white">Bill Expense</text>
                            
                            <text x="25" y="40" font-size="5" fill="white">35%</text>
                            <text x="25" y="45" font-size="3" fill="white">Others</text>
                        </svg>
                    </div>
                </div>
                
                <!-- Notes Card -->
                <div class="notes-card">
                    <h2 class="notes-title">Unggah Catatan</h2>
                    <p class="notes-subtitle">Unggah catatanmu untuk berbagi dengan teman!</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>