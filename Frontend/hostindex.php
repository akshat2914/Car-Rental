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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Host Your Car |Car Matrix</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(to right, #b5aedc, #ffffff);
      color: #333;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 5%;
      background-color: white;
      box-shadow: 0 2px 12px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .logo {
      border: 0px;
      background-color: #ffffff;
      font-size: 26px;
      font-weight: bold;
      color: #7c3aed;
    }

    .nav-links a {
      margin-right: 20px;
      text-decoration: none;
      color: #555;
      font-weight: 500;
    }

    .download-btn, .call-btn {
      margin-right: 10px;
      padding: 10px 20px;
      border-radius: 6px;
      border: 2px solid #7c3aed;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
    }

    .download-btn {
      background: #7c3aed;
      color: white;
    }

    .download-btn:hover {
      background: #503f6c;
    }

    .call-btn {
      background: white;
      color: #7c3aed;
    }

    .call-btn:hover {
      background: #f3e8ff;
    }

    .akshat {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 60px 5%;
      flex-wrap: wrap;
    }

    .akshat-text {
      max-width: 50%;
    }

    .akshat-text h2 {
      font-size: 50px;
      margin-bottom: 20px;
      color: #1f2937;
    }

    .akshat-text h2 span {
      color: #7c3aed;
    }

    .akshat-text p {
      font-size: 18px;
      color: #6b7280;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .start-hosting-btn {
      display: inline-block;
      background-color: #7c3aed;
      color: white;
      padding: 14px 32px;
      font-size: 18px;
      border-radius: 8px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .start-hosting-btn:hover {
      background-color: #5b21b6;
    }

    .st {
      display: flex;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .st-item {
      margin-right: 40px;
      text-align: center;
      margin-top: 20px;
    }

    .st-item h3 {
      font-size: 26px;
      color: #7c3aed;
    }

    .st-item p {
      margin-top: 5px;
      color: #6b7280;
    }

    .akshat-image img {
      width: 450px;
      border-radius: 12px;
      background: #f3e8ff;
      padding: 20px;
    }

    .form-section {
     background: linear-gradient(to right, #b5aedc, #ffffff);
      padding: 60px 5%;
      margin-top: 60px;
    }

    .form-section h2 {
      text-align: center;
      color: #7c3aed;
      margin-bottom: 40px;
      font-size: 36px;
    }

    form {
      max-width: 600px;
      margin: 0 auto;
      background: rgb(255, 255, 255);
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    form input, form select {
      width: 100%;
      padding: 14px;
      margin-bottom: 25px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 16px;
      background-color: #f9fafb;
    }

    form input[type="file"] {
      padding: 8px;
    }

    .submit-btn {
      background-color: #241c32;
      color: white;
      border: none;
      padding: 14px 20px;
      width: 100%;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .submit-btn:hover {
      background-color: #5b21b6;
    }
    @media (max-width: 768px) {
      .akshat {
        flex-direction: column;
        text-align: center;
      }
      
      .akshat-text, .akshat-image {
        max-width: 100%;
      }

      .akshat-image img {
        width: 100%;
        margin-top: 30px;
      }

      .st {
        flex-direction: column;
        align-items: center;
      }

      .st-item {
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>

  <header class="navbar">
    <button class="logo" onclick="window.location.href='index.html';">Car Matrix</button>
    <div class="nav-links">
      <button class="download-btn" onclick="window.location.href='vendorindex.php';">My Dashboard</button>
      <button class="call-btn" href="https://wa.me/+919993605093">Call Us</button>
    </div>
  </header>

  <section class="akshat">
    <div class="akshat-text">
      <h2>Welcome <?php echo htmlspecialchars($user['fullname']);?><br><br> <span>Start Earning Today!</span></h2><br>
      <h3><p>You Are a host on Indore's trusted car rental platform and you can turn your car into a money-making machine.Just register your car in few clicks</p></h3>
      <a href="#form" class="start-hosting-btn">Register Now</a>

      <div class="st">
        <div class="st-item">
          <h3>3K+</h3>
          <p>Live Hosts</p>
        </div>
        <div class="st-item">
          <h3>₹100K+</h3>
          <p>Earned by Hosts</p>
        </div>
        <div class="st-item">
          <h3>3+</h3>
          <p>Cities</p>
        </div>
        <div class="st-item">
          <h3>4300K+</h3>
          <p>Trips Served</p>
        </div>
      </div>
    </div>
    <div class="akshat-image">
      <img src="assets\hostwelcome.jpg" alt="Car Rental Hosting">
    </div>
</section>
    <section id="form" class="form-section">
    <h2>Submit Your Car Details</h2>
    <form action="vendor.php" method="POST" enctype="multipart/form-data">
      <input type="text" name="owner_name" placeholder="Owner Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <select name="car_model" required>
        <option value="">Select Your Car Model</option>
        <option value="Wagon R">Wagon R</option>
        <option value="Swift">Swift</option>
        <option value="Hyundai Creta">Hyundai Creta</option>
        <option value="Mahindra">Mahindra</option>
        <option value="Corolla">Corolla</option>
        <option value="Fortuner">Fortuner</option>
        <option value="Hyundai Aura">Hyundai Aura</option>
        <option value="Scorpio">Scorpio</option>

      </select>
      <input type="text" name="car_registration_number" placeholder="Car Registration Number" required maxlength="10">
      <select name="city" required>
        <option value="">Select City</option>
        <option value="Indore">Indore</option>
        <option value="Rau">Rau</option>
        <option value="Dewas">Dewas</option>
        <option value="Bhopal">Bhopal</option>
      </select>
      <input type="file" name="car_photo" required>
      <button type="submit" class="submit-btn">Register My Car</button>
    </form>
  </section>
  
  </section>
</body>
</html>
