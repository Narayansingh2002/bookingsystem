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

$service_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
include 'display-notifications.php';
$stmt = $mysqli->prepare("SELECT name, email, types, profilepicture, profiledescription FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servicename = $_POST['servicename'];
    $description = $_POST['servicedescription'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];

$stmt = $mysqli->prepare("UPDATE services SET servicename = ?, servicedescription = ?, duration = ?, price = ? WHERE id = ?");
$stmt->bind_param("ssdii", $servicename, $description, $duration, $price, $service_id);
    $stmt->execute();

       $notificationcontent = "$servicename has been updated";

    $stmt = $mysqli->prepare("INSERT INTO notifications (user_id, notificationcontent) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $notificationcontent);
    $stmt->execute();

    header("Location: manageservices-admin.php?serviceupdated=1");
    exit;
}


$stmt = $mysqli->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$editservice = $result->fetch_assoc();
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
            <p class="form-title">Update Service</p>
            <form method="POST">
            <div class="input-text">
                <label for="servicename">Service Name</label>
                 <input type="text" name="servicename" value="<?= htmlspecialchars($editservice['servicename']) ?>">
            </div>
            <div class="input-text">
                <label for="servicedescription">Service Description</label>
                <textarea class="description" name="servicedescription"> <?= htmlspecialchars($editservice['servicedescription']) ?></textarea>
            </div>
            <div class="input-text">
                <label for="duration">Duration</label>
                <input type="number" name="duration" value="<?= htmlspecialchars($editservice['duration']) ?>">
            </div>
            <div class="input-text">
                <label for="servicename">Price</label>
                <input type="number" name="price" value="<?= htmlspecialchars($editservice['price']) ?>">
            </div>
            <button type="submit" class="login-button">Update</button>
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