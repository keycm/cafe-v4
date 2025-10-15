<?php
include 'session_check.php';
// Database connection and data fetching can go here if needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sales Dashboard</title>
  <link rel="stylesheet" href="CSS/admin.css"/>
  <link rel="stylesheet" href="CSS/sales.css"/>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="admin-container">
    
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <header class="main-header">
            <h1>Sales Dashboard</h1>
            <a href="logout.php" class="logout-button">Log Out</a>
        </header>
        
        <div class="sales-main-wrapper">
          <div class="sales-container">
            <div class="sales-header">
              <div>
                <h1>₱ 143,000</h1>
                <p>Total Sales</p>
              </div>
              <div class="sales-legend">
                <span><span class="sales-dot sales-earned"></span> Earned</span>
                <span><span class="sales-dot sales-forecasted"></span> Forecasted</span>
                <select class="sales-dropdown">
                  <option>6 months</option>
                </select>
              </div>
            </div>
            <canvas id="sales-chart"></canvas>
          </div>
      
          <div class="right-column">
              <div class="sales-order-container">
                <div class="sales-order-header">
                  <h3>Order Time</h3>
                  <button class="sales-report-btn">View Report</button>
                </div>
                <p class="sales-date-range">From 1–6 Dec, 2020</p>
                <canvas id="sales-order-chart"></canvas>
          
                <div class="sales-order-legend">
                  <div class="sales-legend-item">
                    <div class="sales-legend-dot dot-afternoon"></div>
                    <span>Afternoon</span><small>40%</small>
                  </div>
                  <div class="sales-legend-item">
                    <div class="sales-legend-dot dot-evening"></div>
                    <span>Evening</span><small>32%</small>
                  </div>
                  <div class="sales-legend-item">
                    <div class="sales-legend-dot dot-morning"></div>
                    <span>Morning</span><small>28%</small>
                  </div>
                </div>
              </div>

              <div class="card">
                <h2>Most Ordered</h2>
                <p class="subtext">📍Fortuna, Floridablanca Pampanga</p>
                <div class="food-list">
                  <div class="food-item"><img src="assets/shoes3 1.png"><span class="food-name">shoes</span><span class="food-price">₱ 210.00</span></div>
                  <div class="food-item"><img src="assets/shoes3 1.png" ><span class="food-name">shoes</span><span class="food-price">₱ 200.00</span></div>
                  <div class="food-item"><img src="assets/shoes3 1.png" ><span class="food-name">shoes shoes</span><span class="food-price">₱ 185.00</span></div>
                </div>
              </div>
          </div>
        </div>
    </main>
  </div>

<script>
  window.onload = function () {
    const ctx1 = document.getElementById("sales-chart").getContext("2d");
    new Chart(ctx1, { type: "line", data: { labels: ["FEB", "MAR", "APR", "MAY", "JUN", "JUL"], datasets: [{ label: "Earned", data: [80, 40, 141, 50, 60, 90], borderColor: "#4b3cdb", backgroundColor: "transparent", tension: 0.4, borderWidth: 3, pointRadius: 0 }, { label: "Forecasted", data: [50, 60, 100, 90, 30, 80], borderColor: "#00cc44", backgroundColor: "transparent", tension: 0.4, borderWidth: 3, pointRadius: 0 }] }, options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 200 } } } });
    const ctx2 = document.getElementById("sales-order-chart").getContext("2d");
    new Chart(ctx2, { type: "doughnut", data: { labels: ["Afternoon", "Evening", "Morning"], datasets: [{ data: [1890, 1512, 1320], backgroundColor: ["#3f3fff", "#888fff", "#cdd3ff"], borderWidth: 0, cutout: "70%" }] }, options: { responsive: true, plugins: { legend: { display: false } } } });
  };
</script>
</body>
</html>