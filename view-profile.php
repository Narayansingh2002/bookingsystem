<?php
session_start();

$mysqli = include 'connection.php';

if (!isset($_GET['id'])) {
    die("User ID is not available");
}

$view_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
include 'display-notifications.php';

$stmt = $mysqli->prepare("SELECT name, location, role, email, types, profiledescription, profilepicture FROM user WHERE id = ?");
$stmt->bind_param("i", $view_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User is not available");
}

$supplier_id = $_GET['id'] ?? null;
$stmt = $mysqli->prepare("SELECT activity_message, created_at FROM activity WHERE user_id = ? ORDER BY created_at DESC LIMIT 6");
$stmt->bind_param("i", $supplier_id);
$stmt->execute();
$activity_result = $stmt->get_result();
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


    

<main class="content" id="content">
        <div class="profile-card">
            <div class="profile-header">
         <div class="image">
    <img class="images" src="uploads/<?= htmlspecialchars($user['profilepicture']) ?>">
        </div>
        <div class="profile-details">
        <h1 class="profile-name"><?php echo htmlspecialchars($user['name']); ?></h1>
            <p class="profile-role"><?php echo htmlspecialchars($user['role']); ?></p>
            <p class="profile-type"><?php echo htmlspecialchars($user['types']); ?></p>
            <p class="profile-email"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
        </div>
        <div class="profile-information">
            <div class="description">
                <h2 class="description-title">About Me</h2>
                <div class="description-content">
                <p class="profile-text"><?php echo htmlspecialchars($user['profiledescription']); ?></p>
                 <div class="profile-locations">
                    <img src="images/location.png" class="image-location">
                <p class="profile-location"><?php echo htmlspecialchars($user['location']); ?></p>
                </div>
                </div>
            </div>
            <div class="activity">
                <h2 class="description-title">Activity</h2>
                <?php while ($activity = $activity_result->fetch_assoc()): ?>
                <div class="activity-content">
                        <div class="activity-item">
                            <h2 class="activity-message"><?php echo htmlspecialchars($activity['activity_message']); ?></h2>
                            <p class="activity-date"><?php echo date("d M Y, H:i", strtotime($activity['created_at'])); ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
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