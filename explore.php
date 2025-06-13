<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Customer') {
    header('Location: login.php');
    exit;
}
$mysqli = require __DIR__ . "/connection.php";

$search = $_GET['search'] ?? '';

$query = "
    SELECT s.id AS service_id, s.servicename, s.servicedescription, s.price, s.duration,
           u.id AS supplier_id, u.name AS supplier_name, u.profilepicture
    FROM services s
    JOIN user u ON s.supplier_id = u.id
    WHERE s.servicename LIKE ? OR u.name LIKE ?
    ORDER BY RAND() LIMIT 10
";

// search
$param = "%" . $search . "%";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $param, $param);
$stmt->execute();
$results = $stmt->get_result();

//filter price

$sql = "
    SELECT 
        s.id AS service_id,
        s.servicename,
        s.servicedescription,
        s.price,
        s.duration,
        s.supplier_id,
        u.name AS supplier_name,
        u.role AS supplier_role,
        u.profilepicture
    FROM services s
    JOIN user u ON s.supplier_id = u.id
    WHERE s.servicename LIKE ? OR u.name LIKE ?
";


$params = ["%$search%", "%$search%"];
$types = "ss";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$services = $result->fetch_all(MYSQLI_ASSOC);


// logged in user information
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare("SELECT id, name, email, types, profilepicture, profiledescription FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// notifications
$stmt = $mysqli->prepare("SELECT notificationcontent, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 6");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = $result->fetch_all(MYSQLI_ASSOC);

// Recommended users
$sql = "SELECT id, name, role, profilepicture, profiledescription FROM user WHERE types = 'Owner' ORDER BY RAND() LIMIT 4";
$result = $mysqli->query($sql);
$recommendedusers = $result->fetch_all(MYSQLI_ASSOC);


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
    <div class="search-container">
        <h1 class="search-title">Discover what's new</h1>
        <form method="GET" action="explore.php" class="search-method">
            <input type="text" name="search" class="search-bar" placeholder="Search for suppliers and services...">
        <button type="submit" class="search-button">Search</button>
        </form>
    </div>

            <?php 
           if (isset($_GET['search'])){
            $search = '%' . ($_GET['search']) . '%';

            $stmt = $mysqli->prepare("SELECT id, name, role, profiledescription, profilepicture FROM user WHERE types = 'Owner' AND (name LIKE ? OR role LIKE ?)");
            $stmt->bind_param("ss", $search, $search);
           }
            else {
             $stmt = $mysqli->prepare("SELECT id, name, role, profiledescription, profilepicture FROM user WHERE types = 'Owner'");
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $searchusers = $result->fetch_all(MYSQLI_ASSOC);

        if (!empty($searchusers)): ?>
         <div class="reccomended-container">
            <h2 class="reccomended-title">Users</h2>
    <div class="reccomended-content">
        <?php foreach ($searchusers as $userresult): ?>
            <div class="reccomended-card">
                <div class="reccomended-images">
                    <img class="reccomended-image" src="uploads/<?= htmlspecialchars($userresult['profilepicture']) ?>" alt="Profile Image">
                </div>
                <p class="reccomended-name"><?= htmlspecialchars($userresult['name']) ?></p>
                <p class="reccomended-role"><?= htmlspecialchars($userresult['role']) ?></p>
                <p class="reccomended-description"><?= htmlspecialchars($userresult['profiledescription']) ?></p>
                <a href="view-profile.php?id=<?= $userresult['id'] ?>" class="reccomended-button">View Profile</a>
            </div>  
        <?php endforeach; ?>
    </div>
</div>
<?php elseif (isset($_GET['search'])): ?>
    <p class="search-message">No users found of username with "<?= htmlspecialchars($_GET['search']) ?>"</p>
<?php endif; ?>

  <div class="searchresults-container">
    <h2 class="searchresults-title">Services</h2>
        <div class="searchresults-content">
            <?php if (!empty($services)): ?>
        <?php foreach ($services as $service): ?>
                <div class="searchresult-card">
                    <div class="card-header">
                    <div class="searchresult-images">
                    <img class="searchresult-image" src="uploads/<?= htmlspecialchars($service['profilepicture']) ?>" alt="Profile Image">
            </div>
            <div class="header-text">
                    <h2 class="searchresult-service"><?= htmlspecialchars($service['servicename']) ?></h2>
                    <a class="searchresult-name" href="view-profile.php?id=<?= $service['supplier_id'] ?>"><?= htmlspecialchars($service['supplier_name']) ?></a>
                    <p class="searchresult-price">£<?= htmlspecialchars($service['price']) ?></p>
            </div>
            </div>
                    <p class="searchresult-description"><?= htmlspecialchars($service['servicedescription']) ?></p>
                     <a class="searchresult-button" href="individual-service.php?service_id=<?= $service['service_id'] ?>">Book</a>
                </div>
               <?php endforeach; ?>
    <?php endif; ?>
            </div>
        </div>


        <div class="reccomended-container">
    <h2 class="reccomended-title">Top Rated Service Providers</h2>
    <div class="reccomended-content">
        <?php foreach ($recommendedusers as $user): ?>
            <div class="reccomended-card">
                <div class="reccomended-images">
                    <img class="reccomended-image" src="uploads/<?= htmlspecialchars($user['profilepicture']) ?>" alt="Profile Image">
                </div>
                <p class="reccomended-name"><?= htmlspecialchars($user['name']) ?></p>
                <p class="reccomended-role"><?= htmlspecialchars($user['role']) ?></p>
                <p class="reccomended-description"><?= htmlspecialchars($user['profiledescription']) ?></p>
                <a href="view-profile.php?id=<?= $user['id'] ?>" class="reccomended-button">View Profile</a>
            </div>  
        <?php endforeach; ?>
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