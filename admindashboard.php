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

$sum_users = $mysqli->query("SELECT COUNT(*) AS total_users FROM user");
$total_users = $sum_users->fetch_assoc()['total_users'];

$sum_bookings = $mysqli->query("SELECT COUNT(*) AS total_bookings FROM bookings");
$total_bookings = $sum_bookings->fetch_assoc()['total_bookings'];

$sql = "SELECT SUM(services.price) as total_price FROM bookings JOIN services on bookings.service_id = services.id";
$sum_price = $mysqli->query($sql);
$total = $sum_price->fetch_assoc();
$total_price = $total['total_price'] ?? 0;

$sum_services = $mysqli->query("SELECT COUNT(*) AS total_services FROM services");
$total_services = $sum_services->fetch_assoc()['total_services'];

$recentlyaddedUsers = $mysqli->query("SELECT email, created_at FROM user ORDER BY created_at DESC LIMIT 6");
$recent_users = $recentlyaddedUsers->fetch_all(MYSQLI_ASSOC);

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
      <?php if (isset($user)): ?>
        
        <h1 class="message">Welcome back <?= htmlspecialchars($user["name"]) ?></h1>
         <p class="message-text">You can manage bookings, services and users and you have full access to the application.</p>

         <div class="cards">
            <div class="card">
                <div class="card-icon">
                    <img src="Images/servicesicon.png" class="icons" alt="Services Icon">
            </div>
            <p class="card-stat"><?php echo $total_services ?></p>
            <p class="card-text">Total Services</p>
         </div>

         <div class="card">
                <div class="card-icon">
                    <img src="Images/order.png" class="icons" alt="Order Icon">
            </div>
            <p class="card-stat"><?php echo number_format($total_price); ?></p>
            <p class="card-text">Total Revenue</p>
         </div>

         <div class="card">
                <div class="card-icon">
                    <img src="Images/userss.png" class="icons" alt="Users Icon">
            </div>
            <p class="card-stat"><?php echo $total_users ?></p>
            <p class="card-text">Total Users</p>
         </div>

         <div class="card">
                <div class="card-icon">
                    <img src="Images/book.png" class="icons" alt="Activity Icon">
            </div>
            <p class="card-stat"><?php echo $total_bookings ?></p>
            <p class="card-text">Total Bookings</p>
         </div>
         </div>

        <h1 class="card-title">Quick Actions</h1>
        <div class="quick-actions">
            <div class="action-card">
                <p class="actioncard-text">Add User</p>
                <a href="add-user.php">
                    <img src="Images/plus.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">View All Bookings</p>
                <a href="managebookings-admin.php">
                    <img src="Images/search.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">View All Services</p>
                <a href="manageservices-admin.php">
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
            <h1 class="table-title">Recently added users</h1>
        <table id="upcoming-bookings">
    <tr>
        <th>Email</th>
        <th>Account Creation</th>
    </tr>

<?php foreach ($recent_users as $recentusers): ?>
    <tr>
        <td><?php echo htmlspecialchars($recentusers['email']); ?></td>
        <td><?php echo date("d M Y, H:i", strtotime($recentusers['created_at'])); ?></td>
    </tr>
<?php endforeach; ?>
</table>
</div>
        
    
    <?php else: ?>
        <p>Please log in to access your dashboard <a href="login.php">Here</a></p>
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