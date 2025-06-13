<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Customer') {
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

$customer_id = $_SESSION['user_id'];
include 'display-notifications.php';
$stmt = $mysqli->prepare("SELECT name, email, types, profilepicture, profiledescription FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$today = date('Y-m-d');

$stmt = $mysqli->prepare("
        SELECT
         bookings.*, 
    services.servicename, 
    services.duration, 
    user.id AS owner_id,
    user.name AS owner_name,
    user.email AS owner_email,
    user.profiledescription AS owner_description,
    user.profilepicture AS owner_picture
FROM bookings 
JOIN services ON bookings.service_id = services.id 
JOIN user ON services.supplier_id = user.id 
WHERE bookings.client_id = ? 
  AND bookings.bookingdatetime >= ?
ORDER BY bookings.bookingdatetime ASC
");
$stmt->bind_param("is", $customer_id, $today);
$stmt->execute();
$result = $stmt->get_result();


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
                <a href="customerdashboard.php" class="navbar-link">Home</a>
                <a href="manage-bookings.php" class="navbar-link">My Bookings</a>
                <a href="explore.php" class="navbar-link">Explore</a>
                <a href="#" class="navbar-link">Support</a>
            </nav>
    </div>
    <button id="openbutton">
        <img src="Images/menubutton.png" class="menubutton">
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

<div class="content" id="content">
      <?php if (isset($user)): ?>
        
        <h1 class="message">Welcome back <?= htmlspecialchars($user["name"]) ?></h1>
        <p class="message-text">You can manage your bookings, make changes to your profile and search for new sessions.</p>
        <h1 class="card-title">Quick Actions</h1>
        <div class="quick-actions">
            <div class="action-card">
                <p class="actioncard-text">Add Booking</p>
                <a href="add-booking.php">
                    <img src="Images/plus.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">View All Bookings</p>
                <a href="manage-bookings.php">
                    <img src="Images/search.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">View All Owners</p>
                <a href="explore.php">
                    <img src="Images/search.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">Edit Profile</p>
                <a href="edit-profile.php">
                    <img src="Images/edit.png" class="actioncard-icon">
                </a>
            </div>
        </div>

        <div class="table">
            <h1 class="table-title">Upcoming Bookings</h1>
        <table id="upcoming-bookings">
    <tr>
        <th>Owner Name</th>
        <th>Service Name</th>
        <th>Date & Time</th>
    </tr>

<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
         <td><a href="view-profile.php?id=<?= $row['owner_id'] ?>"><?= htmlspecialchars($row['owner_name']) ?></a></td>
        <td><?php echo htmlspecialchars($row['servicename']); ?></td>
        <td><?php echo date("d M Y, H:i", strtotime($row['bookingdatetime'])); ?></td>
    </tr>
<?php endwhile; ?>
</table>
</div>

    
    <?php else: ?>
        <p>Please log in to access your dashboard <a href="login.php">Here</a></p>
        <?php endif; ?>
        </div>
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