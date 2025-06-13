<?php
$mysqli = require 'connection.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("DELETE FROM user WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manageusers-admin.php?userdeleted=1");
exit;