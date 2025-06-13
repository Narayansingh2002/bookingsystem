<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Customer') {
    header('Location: login.php');
    exit;
}

if (empty($_POST["bookingdatetime"])) {
    die("Please enter a date and time");
}

if (empty($_POST["service_id"])) {
    die("No service id");
}

$service_id = $_POST['service_id'];
$bookingdatetime = date('Y-m-d H:i:s', strtotime($_POST['bookingdatetime']));
$additionalinformation = $_POST['additionalinformation'];
$client_id = $_SESSION['user_id'];


$sql = "INSERT INTO bookings (service_id, bookingdatetime, additionalinformation, client_id) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

if (! $stmt) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("issi", $service_id, $bookingdatetime, $additionalinformation, $client_id);


if ($stmt->execute()) {
    header("Location: manage-bookings.php?success=1");
    exit;
} else {
    die("Application error: " . $stmt->error . " (" . $stmt->errno . ")");
}
?>