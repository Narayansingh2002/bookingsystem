<?php
if (!isset($mysqli)) {
    $mysqli = require __DIR__ . '/connection.php';
}

if (!isset($_SESSION['user_id'])) {
    return;
}

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT notificationcontent, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 6");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>