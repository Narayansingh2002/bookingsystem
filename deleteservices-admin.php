<?php
$mysqli = require 'connection.php';

$service_id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();

header("Location: manageservices-admin.php?servicedeleted=1");
exit;