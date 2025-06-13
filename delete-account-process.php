<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mysqli = require __DIR__ . "/connection.php";
$user_id = $_SESSION['user_id'];


$stmt = $mysqli->prepare("DELETE FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

session_unset();
session_destroy();

header("Location: login.php");
exit;
?>