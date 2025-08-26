<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_db";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$owner_name = $_POST['owner_name'] ?? '';
$email = $_POST['email'] ?? '';
$car_model = $_POST['car_model'] ?? '';
$car_registration_number = $_POST['car_registration_number'] ?? '';
$city = $_POST['city'] ?? '';

$car_photo = null;

// Handle file upload
if (isset($_FILES['car_photo']) && $_FILES['car_photo']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['car_photo']['tmp_name'];
    $file_name = basename($_FILES['car_photo']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $new_filename = uniqid("car_") . "." . $file_ext;
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $upload_path = $upload_dir . $new_filename;

    if (move_uploaded_file($file_tmp, $upload_path)) {
        $car_photo = $new_filename;
    } else {
        die("Failed to move uploaded file.");
    }
} else {
    die("File upload error: " . $_FILES['car_photo']['error']);
}


if (!$owner_name || !$email || !$car_model || !$car_registration_number || !$city || !$car_photo) {
    die("Please fill in all required fields.");
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO vendors (owner_name, email, car_model, car_registration_number, city, car_photo) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $owner_name, $email, $car_model, $car_registration_number, $city, $car_photo);

if ($stmt->execute()) {
    echo "<script>alert('Registration successful!'); window.location.href='vendorindex.php';</script>";
} else {
    echo "Database error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
