<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Profile - Car Matrix</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #f5f7fa;
    }
    .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #8a79f0;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

    .header {
      background-color: white;
      display: flex;
      justify-content: space-between;
      padding: 10px;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #8a79f0;
    }

    .nav ul {
      display: flex;
      list-style: none;
      gap: 20px;
    }

    .nav ul li {
      cursor: pointer;
      font-weight: 500;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      background-size: cover;
      background-position: center;
      border-radius: 50%;
      margin-left: 20px;
    }

    .profile-banner {
      background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb') no-repeat center;
      background-size: cover;
      height: 150px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .profile-banner h1 {
      color: white;
      font-size: 36px;
    }

    .container {
      display: flex;
      max-width: 1200px;
      margin: 30px auto;
      gap: 20px;
    }

    .sidebar {
      width: 300px;
      background: white;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
    }

    .profile-img img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 3px solid#8a79f0;
    }

    .sidebar h3 {
      margin: 10px 0 5px;
    }

    .sidebar p {
      color: gray;
      margin-bottom: 20px;
    }

    .sidebar-menu {
      list-style: none;
      padding: 0;
    }

    .sidebar-menu li {
      margin: 10px 0;
    }

    .sidebar-menu li a {
      text-decoration: none;
      color: black;
      font-weight: 500;
      padding: 10px;
      display: block;
      border-radius: 5px;
    }

    .sidebar-menu li.active a,
    .sidebar-menu li a:hover {
      background-color:#8a79f0;
      color: white;
    }

    .profile-content {
      flex: 1;
      background: white;
      padding: 20px;
      border-radius: 10px;
    }

    .tabs {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .tabs button {
      background: none;
      border: none;
      font-size: 16px;
      padding-bottom: 5px;
      border-bottom: 2px solid transparent;
      cursor: default;
      font-weight: bold;
      color:#8a79f0;
    }

    .info-group {
      margin-bottom: 20px;
    }

    .info-group label {
      font-weight: 600;
      color: #555;
    }

    .info-group p {
      margin-top: 5px;
      font-size: 16px;
    }

    .dl-photo img {
      width: 300px;
      border: 2px solid #ddd;
      border-radius: 10px;
    }
  </style>
</head>
  <header class="header">
    <div class="logo">Car Matrix</div>
    <nav class="nav">
      <div class="profile-pic"></div>
    </nav>
  </header>

  <section class="profile-banner">
    <h1>My Profile</h1>
  </section>

  <main class="container">
    <aside class="sidebar">
      <div class="profile-img">
        <img src="assets\client-2.png" alt="User Photo" />
      </div>
      <h1><?php echo htmlspecialchars($user['fullname']); ?></h1>
      <p><?php echo htmlspecialchars($user['email']); ?></p>
      <ul class="sidebar-menu">
       
        <li class="active"><a href="#">My Profile</a></li>
       
      </ul>
    </aside>

    <section class="profile-content">
      <div class="tabs">
        <button>Profile Details</button>
      </div>

      <div class="info-group">
        <label>Username:</label>
        <p><?php echo htmlspecialchars($user['fullname']); ?></p>
      </div>
      <div class="info-group">
        <label>Email:</label>
        <p><?php echo htmlspecialchars($user['email']); ?></p>
      </div>
      <div class="info-group">
        <label>Phone Number:</label>
        <p>+91 <?php echo htmlspecialchars($user['phone']); ?></p>
      </div>
      <div class="info-group">
        <label>Age:</label>
        <p><?php echo htmlspecialchars($user['age']); ?> Yr old</p>
      </div>
      <div class="info-group">
        <label>Aadhaar Number:</label>
        <p><?php echo htmlspecialchars($user['aadhar_number']); ?></p>
      </div>
      <div class="info-group dl-photo">
        <label>Driving License Photo:</label><br />
         <img src="uploads/<?php echo htmlspecialchars($user['photo']); ?>" alt="Driving License">
      </div>
      <div>
        <a href="userindex.php" class="btn"><-Back</a>
        <a href="logout.php" class="btn">Logout</a>
      </div>
    </section>
</body>
</html>
