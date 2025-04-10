<?php
session_start();
include 'db.php';

$auid = $_POST['auid'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE auid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $auid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;
    echo "success";
  } else {
    echo "Invalid password";
  }
} else {
  echo "User not found";
}
?>

