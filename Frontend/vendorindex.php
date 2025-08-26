<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: hostindex.php");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "car_rental_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch vendor data
$sql = "SELECT * FROM vendors LIMIT 1"; // Limit to 1 if you want just the first vendor
$result = $conn->query($sql);
$vendors = $result->fetch_assoc(); // Now this variable is defined and usable
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Inter', sans-serif;
      background-color:rgb(198, 171, 244);
      padding: 30px;
      color: #333;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 2.5rem;
      color: #7c3aed;
    }
    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }
    .card, .status-card {
      background-color: #ffffff;
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }
    .status-cards {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 20px;
    }
    .status-card {
      flex: 1 1 calc(25% - 20px);
      text-align: center;
    }
    .status-card h3 {
      margin-bottom: 10px;
      font-size: 1.1rem;
    }
    .status-card p {
      font-size: 1.25rem;
      font-weight: 600;
      color: #7c3aed;
    }
    .car-image img {
      width: 100%;
      border-radius: 12px;
      margin-top: 15px;
    }
    .car-image p {
      margin-top: 8px;
      font-size: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      font-size: 0.95rem;
    }
    .btn {
      background-color: #4a00e0;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .btn:hover {
      background-color: #3700b3;
    }
    .chart-bar {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      height: 150px;
      margin-top: 20px;
    }
    .bar {
      width: 30px;
      border-radius: 8px 8px 0 0;
      transition: all 0.3s ease;
    }
    .tracking h2, .live-status h2, .car-image h2 {
      margin-bottom: 15px;
      font-size: 1.5rem;
    }
    .logout-container {
  position: absolute;
  top: 20px;
  right: 30px;
}

.logout-btn {
  background-color: #7c3aed;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: background 0.3s;
}

.logout-btn:hover {
  background-color: black;
}
.status-card canvas {
  width: 100% !important;
  height: 150px !important;
}

  </style>
</head>
<body>
  <div class="logout-container">
  <form action="logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
  </form>
</div>

  <h1>Car Dashboard</h1>
  <div class="dashboard">
    <div class="status-cards">
      <div class="status-card">
        <h3>Monthly Books</h3>
        <p>15</p>
      </div>
      <div class="status-card">
        <h3>Total Bookings</h3>
        <p>256</p>
      </div>
      <div class="status-card">
        <h3>Monthly Earning</h3>
        <p>Rs.6700/-</p>
      </div>
      <div class="status-card">
        <h3>Monthly Income Chart</h3>
      <canvas id="incomeChart"></canvas>
      </div>
    </div>
    <div class="card car-image">
 <?php if (!empty($vendors['car_model'])): ?>
    <h2><?php echo htmlspecialchars($vendors['car_model']); ?></h2>
  <?php else: ?>
    <h2><strong>Register Your Car first</strong></h2>
  <?php endif; ?>

  <?php if (!empty($vendors['car_photo'])): ?>
    <img src="uploads/<?php echo htmlspecialchars($vendors['car_photo']); ?>" alt="Car Photo">
  <?php else: ?>
    <p><strong>No image available</strong></p>
  <?php endif; ?>

  <?php if (!empty($vendors['car_registration_number'])): ?>
    <p>Registration Number: <?php echo htmlspecialchars($vendors['car_registration_number']); ?></p>
  <?php else: ?>
    <p><strong>No registration number provided</strong></p>
  <?php endif; ?>

  <?php if (!empty($vendors['city'])): ?>
    <p>Registered City: <?php echo htmlspecialchars($vendors['city']); ?></p>
  <?php else: ?>
    <p><strong>No city provided</strong></p>
  <?php endif; ?>

  <?php if (!empty($vendors['owner_name'])): ?>
    <p>Registered Owner Name: <?php echo htmlspecialchars($vendors['owner_name']); ?></p>
  <?php else: ?>
    <p><strong>No owner name provided</strong></p>
  <?php endif; ?>

  <p>Fuel Type: Petrol</p>

  <?php if (!empty($vendors['email'])): ?>
    <p>Registered Email: <?php echo htmlspecialchars($vendors['email']); ?></p>
  <?php else: ?>
    <p><strong>No email provided</strong></p>
  <?php endif; ?>
</div>


    <div class="card car-image">
      <h2>Hyundai Creta</h2>
      <img src="assets\creta.jpg" alt="Creta">
      <p>Registration Number:MP12DN7272</P>
      <p>Registered City: Bhopal</p>
      <p>Registered Owner Name:<?php echo htmlspecialchars($vendors['owner_name']);?></p></p>
      <p>Fuel Type: Petrol</p>
      <p>Registered email: <?php echo htmlspecialchars($vendors['email']);?></p></p></p>
    </div>
    <div class="card live-status">
      <h2>Live Car Status</h2>
      <table>
        <thead>
          <tr>
            <th>No.</th>
            <th>Car no.</th>
            <th>Driver</th>
            <th>Status</th>
            <th>Earning</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>01</td>
            <td>7272</td>
            <td>Vishal Singh</td>
            <td>Completed</td>
            <td>Rs.3500/-</td>
         
          </tr>
          <tr>
            <td>02</td>
            <td>5665</td>
            <td>Vivek Kumar</td>
            <td>Pending</td>
            <td>Rs.00/-</td>
            
          </tr>
          <tr>
            <td>03</td>
            <td>1755</td>
            <td>Yash Rajput</td>
            <td>In route</td>
            <td>Rs.5000/-</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="card tracking">
      <h2>Tracking History</h2>
      <div class="chart-bar">
        <div class="bar" style="height: 60px; background-color: #ff9f1c;"></div>
        <div class="bar" style="height: 120px; background-color: #5f27cd;"></div>
        <div class="bar" style="height: 80px; background-color: #43bccd;"></div>
        <div class="bar" style="height: 100px; background-color: #3ac569;"></div>
        <div class="bar" style="height: 90px; background-color: #f72585;"></div>
        <div class="bar" style="height: 50px; background-color: #ff9f1c;"></div>
        <div class="bar" style="height: 130px; background-color: #5f27cd;"></div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctxIncome = document.getElementById('incomeChart').getContext('2d');
  new Chart(ctxIncome, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
        label: 'Income',
        data: [12000, 19000, 30000, 25000],
        backgroundColor: 'rgba(75, 192, 192, 0.6)'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });

  const ctxExpense = document.getElementById('expenseChart').getContext('2d');
  new Chart(ctxExpense, {
    type: 'doughnut',
    data: {
      labels: ['Rent', 'Utilities', 'Salaries'],
      datasets: [{
        label: 'Expenses',
        data: [1000, 500, 1500],
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });

  const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
  new Chart(ctxRevenue, {
    type: 'line',
    data: {
      labels: ['Q1', 'Q2', 'Q3', 'Q4'],
      datasets: [{
        label: 'Revenue',
        data: [5000, 7000, 6500, 8000],
        borderColor: '#4bc0c0',
        fill: false
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });

  const ctxProfit = document.getElementById('profitChart').getContext('2d');
  new Chart(ctxProfit, {
    type: 'polarArea',
    data: {
      labels: ['Product A', 'Product B', 'Product C'],
      datasets: [{
        label: 'Profit Margin',
        data: [20, 30, 50],
        backgroundColor: ['#FF6384', '#4BC0C0', '#FFCE56']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  });
</script>

  
</body>
</html>