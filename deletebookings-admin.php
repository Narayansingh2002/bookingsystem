<?php
$mysqli = require 'connection.php';

$booking_id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();

header("Location: managebookings-admin.php?bookingdeleted=1");
exit;