<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Admin') {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/connection.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT notificationcontent, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 6");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = $result->fetch_all(MYSQLI_ASSOC);

$displaybookings= mysqli_query($mysqli, "
    SELECT bookings.id, user.name AS customersname, services.servicename, bookings.bookingdatetime
    FROM bookings
    JOIN user ON bookings.client_id = user.id
    JOIN services ON bookings.service_id = services.id
    ORDER BY bookingdatetime
");
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
       <h1 class="services-title">Manage Bookings</h1>
    <a href="addbooking-admin.php" class="add-service">Add Booking</a>
    <div class="services-container">
    <table id="services">
        <tr>
            <th>Customer</th>
            <th>Service</th>
            <th>Date and Time</th>
            <th>Action</th>
        </tr>
        <?php while ($bookings = mysqli_fetch_assoc($displaybookings)): ?>
        <tr>
            <td><?= htmlspecialchars($bookings['customersname']) ?></td>
            <td><?= htmlspecialchars($bookings['servicename']) ?></td>
            <td><?= date("d M Y, H;i", strtotime($bookings['bookingdatetime'])) ?></td>
            <td class="table-actions">
                <a href="updatebookings-admin.php?id=<?= $bookings['id'] ?>" class="edit-button">Edit</a>
                <a href="deletebookings-admin.php?id=<?= $bookings['id'] ?>" class="delete-button">Delete</a>
            </td>
        </tr>
         <?php endwhile; ?>
        </table>
        </div>
        <?php if (isset($_GET['bookingadded'])): ?>
            <div id="pm" class="popup-message">Booking has been added</div>
            <?php endif; ?>
         <?php if (isset($_GET['bookingupdated'])): ?>
            <div id="pm" class="popup-message">Booking has been updated</div>
            <?php endif; ?>
              <?php if (isset($_GET['bookingdeleted'])): ?>
            <div id="pm" class="delete-service">Booking has been deleted</div>
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