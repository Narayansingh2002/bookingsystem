<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Customer') {
    header('Location: login.php');
    exit;
}

$mysqli = include 'connection.php';
$stmt = $mysqli->prepare("SELECT name, email, types, profilepicture, profiledescription FROM user WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


$customer_id= $_SESSION['user_id'];
$stmt = $mysqli->prepare("
    SELECT 
        services.servicename, 
        services.duration, 
        services.price, 
        user.name AS owner_name, 
        bookings.bookingdatetime
    FROM bookings
    JOIN services ON bookings.service_id = services.id
    JOIN user ON services.supplier_id = user.id
    WHERE bookings.client_id = ?
    ORDER BY bookings.bookingdatetime DESC;
");

$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
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
    <div class="services-container">
    <h1 class="services-title">Manage Bookings</h1>
    <a href="add-booking.php" class="add-service">Add Booking</a>
    <table id="services">
        <tr>
            <th>Owner</th>
            <th>Service Name</th>
            <th>Service Duration (mins)</th>
            <th>Price</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= htmlspecialchars($row['owner_name']) ?></td>
            <td><?= htmlspecialchars($row['servicename']) ?></td>
            <td><?= htmlspecialchars($row['duration']) ?></td>
            <td><?= htmlspecialchars($row['price']) ?></td>
            <td><?= date("d M Y, H:i", strtotime($row['bookingdatetime'])) ?></td>
        </tr>
      
        <?php endwhile; ?>
        </table>
        </div>
          <?php if (isset($_GET['success'])): ?>
            <div id="pm" class="popup-message">Booking has been added</div>
            <?php endif; ?>
       
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