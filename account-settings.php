<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}



$mysqli = require __DIR__ . "/connection.php";
$user_id = $_SESSION['user_id'];
include 'display-notifications.php';
$stmt = $mysqli->prepare("SELECT name, email, location, role, profilepicture, created_at, profiledescription FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
         <?php if ($_SESSION['types'] === 'Admin'): ?>
               <div class="sidebar" id="sidebar">
        <button class="mobileview" id="closebutton">
            <img src="Images/closebutton.png" class="menubutton">
        </button>
         <div class="logo">
            <img class="icon" src="Images/iconlogo.png" alt="logo">
            TechAthletics</div>

            <nav class="navbar-links">
                <a href="admindashboard.php" class="navbar-link">Home</a>
                <a href="manage-application.php" class="navbar-link">Manage Application</a>
            </nav>
    </div>
            <?php endif; ?>
     <?php if ($_SESSION['types'] === 'Owner'): ?>
               <div class="sidebar" id="sidebar">
        <button class="mobileview" id="closebutton">
            <img src="Images/closebutton.png" class="menubutton">
        </button>
         <div class="logo">
            <img class="icon" src="Images/iconlogo.png" alt="logo">
            TechAthletics</div>

            <nav class="navbar-links">
                <a href="ownerdashboard.php" class="navbar-link">Home</a>
                <a href="manage-services.php" class="navbar-link">Manage Services</a>
                <a href="order-history.php" class="navbar-link">Order History</a>
                <a href="#" class="navbar-link">Support</a>
            </nav>
    </div>
            <?php endif; ?>

            
             <?php if ($_SESSION['types'] === 'Customer'): ?>
         <div class="sidebar" id="sidebar">
        <button class="mobileview" id="closebutton">
            <img src="Images/closebutton.png" class="menubutton">
        </button>
         <div class="logo">
            <img class="icon" src="Images/iconlogo.png" alt="logo">
            TechAthletics</div>

            <nav class="navbar-links">
                <a href="customerdashboard.php" class="navbar-link">Home</a>
                <a href="manage-bookings.php" class="navbar-link">My Bookings</a>
                <a href="explore.php" class="navbar-link">Explore</a>
                <a href="#" class="navbar-link">Support</a>
            </nav>
    </div>
            <?php endif; ?>
    <button id="openbutton">
        <img src="Images/menubutton.png" class="openbtn">
    </button>


            <div class="user-actions">
                <div class="notifications-dropdown">
        <button class="not-bell"><img src="Images/notification.png" class="bell-icon" alt="notification icon"></button>
        <div class="dropdown-content">
            <?php if (empty($notifications)): ?>
            <p class="notification-content">You have no new notifications</p>
        <?php else: ?>
            <?php foreach ($notifications as $notif): ?>
                <div class="notification-content">
                    <p class="notification-item"><?= htmlspecialchars($notif['notificationcontent']) ?></p>
                    <p class="notification-date"><?= date("d, M, H:i", strtotime ($notif['created_at']))?></p>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
                </div>
             </div>
             <div class="userprofile-dropdown">
             <button class="user-icon"><img class="dashboard-icon" src="uploads/<?= htmlspecialchars($user['profilepicture']) ?>"></button>
              <div class="userprofile-content">
                <div class="userprofile-header">
                    <p class="userprofileheader-first"><?= htmlspecialchars($user['name']) ?></p>
                    <p class="userprofileheader-second"><?= htmlspecialchars($user['email']) ?></p>
                </div>
                <p class="userprofile-item"><a href="account-information.php">Account Actions</a></p>
                <p class="userprofile-item"><a href="account-settings.php">Account Settings</a></p>
                <p class="userprofile-item"><a href="profile-page.php">Profile</a></p>
                <p class="userprofile-item"><a href="logout.php">Logout</a></p>
              </div>
            </div>
            </div>
    

<main class="content" id="content">
    <div class="accountinformation-container">
        <h1 class="accountinformation-title">Account Settings</h1>
        <div class="accountinformation-card">
            <h2 class="accountinformationcard-title">Manage account details</h2>
            <hr class="lines">
            <p class="accountinformationcard-holder">You can manage your account security here</p>
            <hr class="lines">
            <div class="accountinformationcard-container">
            <p class="accountinformationcard-holder">Email</p>
            <p class="account-value"><?= htmlspecialchars($user['email']) ?></p>
            <a href="update-email.php" class="account-button">CHANGE</a>
            </div>
            <hr class="lines">
            <div class="accountinformationcard-container">
            <p class="accountinformationcard-holder">Password</p>
            <p class="account-value">******</p>
            <a href="update-password.php" class="account-button">CHANGE</a>
            </div>
            <hr class="lines">
            <div class="accountinformationcard-container">
            <p class="accountinformationcard-holder">Account date</p>
            <p class="account-value"><?= htmlspecialchars($user['created_at']) ?></p>
            <a class="account-button">CHANGE</a>
            </div>
        </div>
         <?php if (isset($_GET['emailupdated'])): ?>
            <div id="pm" class="popup-message">Email has been updated</div>
            <?php endif; ?>
            <?php if (isset($_GET['passwordupdated'])): ?>
            <div id="pm" class="popup-message">Password has been updated</div>
            <?php endif; ?>
    </div>
        
      
    </main>
    </div>

    <script>
           const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const closebutton = document.getElementById('closebutton');
        const openbutton = document.getElementById('openbutton');
        
 
        closebutton.addEventListener('click', function() {
            sidebar.classList.add('closed');
            content.classList.add('full');
            openbutton.classList.add('visible');
        });
        
  
        openbutton.addEventListener('click', function() {
            sidebar.classList.remove('closed');
            content.classList.remove('full');
            openbutton.classList.remove('visible');
        });
        </script>

    
</body>
</html>