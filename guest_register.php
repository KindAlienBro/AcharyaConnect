<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acharyaconnect";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

// Check if fields are empty
if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
    echo "All fields are required.";
    exit;
}

// Check if passwords match
if ($password !== $confirm) {
    echo "Passwords do not match.";
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert guest user
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'guest')");
$stmt->bind_param("sss", $name, $email, $hashedPassword);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
