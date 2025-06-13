<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Owner') {
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

$serviceQuery = $mysqli->query("SELECT COUNT(*) AS total_services FROM services WHERE supplier_id = $user_id");
$services = $serviceQuery->fetch_assoc();

$bookingQuery = $mysqli->query("SELECT COUNT(*) AS total_bookings 
    FROM bookings 
    JOIN services ON bookings.service_id = services.id 
    WHERE services.supplier_id = $user_id");
$bookings = $bookingQuery->fetch_assoc();


$clientBookingQuery = $mysqli->query("SELECT COUNT(*) AS my_bookings FROM bookings WHERE client_id = $user_id");
$myBookings = $clientBookingQuery->fetch_assoc();

$query = "
    SELECT SUM(services.price) AS totalRevenue 
    FROM bookings 
    JOIN services ON bookings.service_id = services.id 
    WHERE services.supplier_id = ?
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($totalRevenue);
$stmt->fetch();
$stmt->close();


$query = "
    SELECT COUNT(DISTINCT bookings.client_id) AS totalCustomers 
    FROM bookings 
    JOIN services ON bookings.service_id = services.id 
    WHERE services.supplier_id = ?
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($totalCustomers);
$stmt->fetch();
$stmt->close();

$query = "
    SELECT SUM(duration) AS totalDuration 
    FROM services 
    WHERE supplier_id = ?
";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($totalDuration);
$stmt->fetch();
$stmt->close();


$owner_id = $_SESSION['user_id'];

$today = date('Y-m-d H:i:s');

$sql = "SELECT b.id, b.bookingdatetime, s.servicename 
        FROM bookings b 
        JOIN services s ON b.service_id = s.id 
        WHERE s.supplier_id = ? AND b.bookingdatetime >= ?
        ORDER BY b.bookingdatetime ASC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("is", $owner_id, $today);
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
                <a href="ownerdashboard.php" class="navbar-link">Home</a>
                <a href="manage-services.php" class="navbar-link">Manage Services</a>
                <a href="order-history.php" class="navbar-link">Order History</a>
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
      <?php if (isset($user)): ?>
        
        <h1 class="message">Welcome back <?= htmlspecialchars($user["name"]) ?></h1>
         <p class="message-text">You can manage your services, interact with clients and analyse your data to get the most out of your services.</p>

         <div class="cards">
            <div class="card">
                <div class="card-icon">
                    <img src="Images/servicesicon.png" class="icons" alt="Services Icon">
            </div>
            <p class="card-stat"><?php echo $services['total_services']; ?></p>
            <p class="card-text">Total Services</p>
         </div>

         <div class="card">
                <div class="card-icon">
                    <img src="Images/order.png" class="icons" alt="Order Icon">
            </div>
            <p class="card-stat"><?php echo number_format($totalRevenue ?? 0, 2); ?></p>
            <p class="card-text">Total Revenue</p>
         </div>

         <div class="card">
                <div class="card-icon">
                    <img src="Images/userss.png" class="icons" alt="Users Icon">
            </div>
            <p class="card-stat"><?php echo $totalCustomers; ?></p>
            <p class="card-text">Total Customers</p>
         </div>

         <div class="card">
                <div class="card-icon">
                    <img src="Images/activity.png" class="icons" alt="Activity Icon">
            </div>
            <p class="card-stat"><?php echo $totalDuration ?? 0; ?> minutes</p>
            <p class="card-text">Activity Time</p>
         </div>
         </div>

        <h1 class="card-title">Quick Actions</h1>
        <div class="quick-actions">
            <div class="action-card">
                <p class="actioncard-text">Add Service</p>
                <a href="add-service.php">
                    <img src="Images/plus.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">View All Bookings</p>
                <a href="order-history.php">
                    <img src="Images/search.png" class="actioncard-icon">
                </a>
            </div>
            <div class="action-card">
                <p class="actioncard-text">View All Services</p>
                <a href="manage-services.php">
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
            <h1 class="table-title">Upcoming Customer Bookings</h1>
        <table id="upcoming-bookings">
    <tr>
        <th>Service Name</th>
        <th>Date & Time</th>
    </tr>

<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['servicename']); ?></td>
        <td><?php echo date("d M Y, H:i", strtotime($row['bookingdatetime'])); ?></td>
    </tr>
<?php endwhile; ?>
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