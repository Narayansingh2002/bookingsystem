<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Owner') {
    header('Location: login.php');
    exit;
}

if (empty($_POST["servicename"])) {
    die("Please enter a service name");
}

if (empty($_POST["servicedescription"])) {
    die("Please enter a service description");
}

if (empty($_POST["duration"])) {
    die("Please enter a service duration");
}

if (empty($_POST["price"])) {
    die("Please enter a service price");
}



$servicename = $_POST['servicename'];
$servicedescription = $_POST['servicedescription'];
$duration = $_POST['duration'];
$price = $_POST['price'];
$name = $_POST['name'];
$supplier_id = $_SESSION['user_id'];

$sql = ("INSERT INTO services (servicename, servicedescription, duration, price, supplier_id) VALUES (?, ?, ?, ?, ?)");

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}
$stmt->bind_param("ssiii", $servicename, $servicedescription, $duration, $price, $supplier_id);


if ($stmt->execute()) {
    header("Location: manage-services.php?success=1");
$stmt = $mysqli->prepare("SELECT name FROM user WHERE id = ?");
$stmt->bind_param("i", $supplier_id);
$stmt->execute();
$result = $stmt->get_result();
$owner = $result->fetch_assoc();

$owner_name = $owner['name'];
$activity_content = $owner_name . " has added a new service " . $servicename;
$activity = 'add_service';

$stmt = $mysqli->prepare("INSERT INTO activity (user_id, activity, activity_message) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $_SESSION['user_id'], $activity, $activity_content);
$stmt->execute();

$notificationcontent = "$servicename has been added";

$stmt = $mysqli->prepare("INSERT INTO notifications (user_id, notificationcontent) VALUES (?, ?)");
$stmt->bind_param("is", $supplier_id, $notificationcontent);
$stmt->execute();
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("Service cannot be made");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>