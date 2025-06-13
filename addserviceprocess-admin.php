<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['types'] !== 'Admin') {
    header('Location: login.php');
    exit;
}

if (empty($_POST["servicename"])) {
    die("Please enter a service name");
}

if (empty($_POST["servicedescription"])) {
    die("Please enter a service description");
}

if (empty($_POST["duration"])) {
    die("Please enter a service duration");
}

if (empty($_POST["price"])) {
    die("Please enter a service price");
}



$servicename = $_POST['servicename'];
$servicedescription = $_POST['servicedescription'];
$duration = $_POST['duration'];
$price = $_POST['price'];
$name = $_POST['name'];
$supplier_id = $_SESSION['user_id'];

$sql = ("INSERT INTO services (servicename, servicedescription, duration, price, supplier_id) VALUES (?, ?, ?, ?, ?)");

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}
$stmt->bind_param("ssiii", $servicename, $servicedescription, $duration, $price, $supplier_id);


if ($stmt->execute()) {
    header("Location: manageservices-admin.php?serviceadded=1");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("Service cannot be made");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>