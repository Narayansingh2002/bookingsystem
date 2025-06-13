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

include 'display-notifications.php';

$displayusers = $mysqli->query("SELECT id, name, email, types, created_at FROM user ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
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
       <h1 class="services-title">Manage Users</h1>
    <a href="add-user.php" class="add-service">Add User</a>
    <div class="services-container">
    <table id="services">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Types</th>
            <th>Account Creation</th>
            <th>Action</th>
        </tr>
        <?php foreach ($displayusers as $users): ?>
        <tr>
            <td><?= htmlspecialchars($users['name']) ?></td>
            <td><?= htmlspecialchars($users['email']) ?></td>
            <td><?= htmlspecialchars($users['types']) ?></td>
            <td><?= date("d M Y, H;i", strtotime($users['created_at'])) ?></td>
            <td class="table-actions">
                <a href="updateusers-admin.php?id=<?= $users['id'] ?>" class="edit-button">Edit</a>
                <a href="deleteusers-admin.php?id=<?= $users['id'] ?>" class="delete-button">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </table>
        </div>
        <?php if (isset($_GET['useradded'])): ?>
            <div id="pm" class="popup-message">User has been added</div>
            <?php endif; ?>
         <?php if (isset($_GET['userupdated'])): ?>
            <div id="pm" class="popup-message">User has been updated</div>
            <?php endif; ?>
              <?php if (isset($_GET['userdeleted'])): ?>
            <div id="pm" class="delete-service">User has been deleted</div>
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