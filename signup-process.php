<?php

if (empty($_POST["name"])) {
    die("Please enter your name");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Please enter your email address");
}

if (strlen($_POST["passwords"]) < 6) {
    die("Password must be at least 6 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["passwords"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["passwords"])) {
    die("Password must contain at least one number");
}

if ($_POST["passwords"] !== $_POST["repeatpassword"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["passwords"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/connection.php";

$sql = "INSERT INTO user (name, email, types, password_hash)
        VALUES (?, ?, ?, ?)";
        
$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ssss",
                  $_POST["name"],
                  $_POST["email"],
                  $_POST["types"],
                  $password_hash);

                  
if ($stmt->execute()) {
    header("Location: account-created.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}