<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$aadhar_number = $_POST['aadhar_number'];
$passsword = $_POST['passsword'];

$photo = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
$upload_path = "uploads/" . basename($photo);
move_uploaded_file($tmp_name, $upload_path);

$driving_license = $photo;

$sql = "INSERT INTO users (fullname, email, phone, passsword, age, driving_license, photo, aadhar_number) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisss", $fullname, $email, $phone, $passsword, $age, $driving_license, $photo, $aadhar_number);

if ($stmt->execute()) {
  echo "<script>alert('Registration successful! You Can Now Login'); window.location.href='register.html';</script>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>