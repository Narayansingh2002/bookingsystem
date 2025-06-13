<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Admin') {
    header('Location: login.php');
    exit;
}

$mysqli = include 'connection.php';

if (!isset($_GET['id'])) {
    die("Service ID not available.");
}

$user_id = $_SESSION['user_id'];
include 'display-notifications.php';
$stmt = $mysqli->prepare("SELECT name, email, types, profilepicture, profiledescription FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

 $booking_id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$bookingdatetime = $_POST['bookingdatetime'];
$additionalinformation = $_POST['additionalinformation'];

$stmt = $mysqli->prepare("UPDATE bookings SET bookingdatetime = ?, additionalinformation = ? WHERE id = ?");
$stmt->bind_param("ssi", $bookingdatetime, $additionalinformation, $booking_id);
$stmt->execute();

       $notificationcontent = "Booking number $booking_id has been updated";

    $stmt = $mysqli->prepare("INSERT INTO notifications (user_id, notificationcontent) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $notificationcontent);
    $stmt->execute();

    header("Location: managebookings-admin.php?bookingupdated=1");
    exit;
}


$stmt = $mysqli->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$editbooking = $result->fetch_assoc();
?>


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
     <div class="screen-container">
        <div class="form-container">
            <p class="form-title">Update Booking</p>
            <form method="POST">
            <div class="input-text">
                <label for="additionalinformation">Additonal Information</label>
                <textarea class="description" name="additionalinformation" <?= htmlspecialchars($editbooking['additionalinformation']) ?>></textarea>
            </div>
            <div class="input-text">
                <label for="bookingdatetime">Date</label>
                <input type="datetime-local" name="bookingdatetime" value="<?= date('Y-m-d\TH:i', strtotime($editbooking['bookingdatetime'])) ?>">
            </div>
            <button type="submit" class="login-button">Update Booking</button>
            </form>
        </div>
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