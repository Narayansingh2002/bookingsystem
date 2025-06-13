<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Owner') {
    header("Location: login.php");
    exit;
}

$mysqli = include 'connection.php';

$service_id = $_POST['id'];
$servicename = $_POST['servicename'];
$description = $_POST['servicedescription'];
$duration = $_POST['duration'];
$price = $_POST['price'];
$supplier_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("UPDATE services SET servicename=?, servicedescription=?, duration=?, price=? WHERE id=? AND supplier_id=?");
$stmt->bind_param("ssiiii", $servicename, $description, $duration, $price, $service_id, $_SESSION['user_id']);


if ($stmt->execute()) {
    header("Location: manage-services.php?edited=1");

    $notificationcontent = "$servicename has been updated";

    $stmt = $mysqli->prepare("INSERT INTO notifications (user_id, notificationcontent) VALUES (?, ?)");
    $stmt->bind_param("is", $supplier_id, $notificationcontent);
    $stmt->execute();
    exit;
} else {
    die("Update failed: " . $stmt->error);
}