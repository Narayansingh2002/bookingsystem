<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$mysqli = include 'connection.php';
$user_id = $_SESSION['user_id'];
include 'display-notifications.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $profiledescription = $_POST['profiledescription'];
    $role = $_POST['role'];
    $location = $_POST['location'];

    $uploadFileName = null;
    if (isset($_FILES['profilepicture']) && $_FILES['profilepicture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profilepicture']['tmp_name'];
        $fileName = basename($_FILES['profilepicture']['name']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($fileExtension), $allowed)) {
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadPath = 'uploads/' . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $uploadFileName = $newFileName;
            }
        }
    }

    if ($uploadFileName) {
        $stmt = $mysqli->prepare("UPDATE user SET name = ?, location = ?, profiledescription = ?, role = ?, profilepicture = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $location, $profiledescription, $role, $uploadFileName, $user_id);
    } else {
        $stmt = $mysqli->prepare("UPDATE user SET name = ?, location = ?, profiledescription = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $location, $profiledescription, $role, $user_id);
    }

    $stmt->execute();
    header('Location: profile-page.php?updated=1');
    exit;
}

$stmt = $mysqli->prepare("SELECT name, email, location, profiledescription, role, profilepicture FROM user WHERE id = ?");
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
                <a href="admindashboard.php" class="navbar-link">Home</a>
                <a href="manage-application.php" class="navbar-link">Manage Application</a>
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
    <div class="screen-container">
        <div class="form-container">
            <p class="form-title">Edit Profile</p>
            <form method="POST" enctype="multipart/form-data">
                 <div class="input-text">
                <label for="profilepicture">Profile Picture</label>
                <input type="file" name="profilepicture" accept="image/*">
            </div>
            <div class="input-text">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
            </div>
            <?php if ($_SESSION['types'] === 'Owner'): ?>
            <div class="input-text">
                <label for="role">Role</label>
                <input type="text" name="role" value="<?= htmlspecialchars($user['role']) ?>">
            </div>
            <?php endif; ?>
            <div class="input-text">
                <label for="location">Location</label>
                <input type="text" name="location" value="<?= htmlspecialchars($user['location']) ?>">
            </div>
              <div class="input-text">
                <label for="profiledescription">Description</label>
                <textarea class="profiledescription" name="profiledescription"><?= htmlspecialchars($user['profiledescription']) ?></textarea>
            </div>
            <button type="submit" class="login-button">Update Profile</button>
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