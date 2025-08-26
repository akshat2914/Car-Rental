<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data and trim spaces
$email = trim($_POST['email']);
$passsword = trim($_POST['passsword']);

// Prepare SQL to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND passsword = ?");
$stmt->bind_param("ss", $email, $passsword);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  // Login successful
  $_SESSION['email'] = $email;
  header("Location: userindex.php");

  exit();
} else {
  // Invalid login
  echo "<script>alert('Invalid email or password.'); window.location.href='register.html';</script>";
}

$stmt->close();
$conn->close();
?>
