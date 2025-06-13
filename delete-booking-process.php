<?php
session_start();
$db = include 'connection.php';


if (!isset($_GET['id'])) {
    die("No booking Id number available");
}


$booking_id = $_GET['id'];

$stmt = $db->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    header("Location: order-history.php?deleted=1");
} else {
    echo "Not deleted: " . $stmt->error;
}