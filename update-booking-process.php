<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Owner') {
    header("Location: login.php");
    exit;
}

$db = include 'connection.php';

$booking_id = $_POST['id'];
$bookingdatetime = $_POST['bookingdatetime'];
$additionalinformation = $_POST['additionalinformation'];

$stmt = $db->prepare("UPDATE bookings SET bookingdatetime = ?, additionalinformation = ? WHERE id = ?");
$stmt->bind_param("ssi", $bookingdatetime, $additionalinformation, $booking_id);

if ($stmt->execute()) {
    header("Location: order-history.php?edited=1");
} else {
    echo "Error: " . $stmt->error;
}