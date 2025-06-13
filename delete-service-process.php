<?php
session_start();


if (!isset($_GET['id'])) {
    die("No Service Id number available");
}

$mysqli = include 'connection.php';
if (!isset($_GET['id'])) {
    die("Service ID not provided.");
}

$service_id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM services WHERE id = ? AND supplier_id = ?");
$stmt->bind_param("ii", $service_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    header("Location: manage-services.php?deleted=1");

exit;

} else {
    echo "Not deleted: " . $stmt->error;
}