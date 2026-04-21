<?php 
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bus Reservation System</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <h1>Bus Reservation System</h1>
    <nav>
      <a href="index.php">Home</a>
      <?php if(isset($_SESSION['user_id'])): ?>
        <?php if($_SESSION['role'] === 'admin'): ?>
          <a href="admin.php">Admin Panel</a>
        <?php else: ?>
          <a href="#">My Bookings</a>
        <?php endif; ?>
        <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a>
      <?php else: ?>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </nav>
  </header>

  <div class="container">
    <h2>Search for Bus Tickets</h2>
    <?php if(isset($_SESSION['success'])): ?>
      <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>
    
    <form action="search.php" method="POST">
      <div class="form-group">
        <label for="source">Source City:</label>
        <select id="source" name="source" required>
          <option value="Pune">Pune</option>
          <option value="Mumbai">Mumbai</option>
          <option value="Nagpur">Nagpur</option>
          <option value="Nashik">Nashik</option>
        </select>
      </div>

      <div class="form-group">
        <label for="destination">Destination City:</label>
        <select id="destination" name="destination" required>
          <option value="Mumbai">Mumbai</option>
          <option value="Pune">Pune</option>
          <option value="Aurangabad">Aurangabad</option>
          <option value="Goa">Goa</option>
        </select>
      </div>

      <div class="form-group">
        <label for="date">Journey Date:</label>
        <input type="date" id="date" name="date" required>
      </div>

      <div class="form-group">
        <label for="passengers">No. of Passengers:</label>
        <input type="number" id="passengers" name="passengers" min="1" max="10" value="1" required>
      </div>

      <button type="submit">Search Buses</button>
    </form>
  </div>

  <div class="container">
    <h2>Popular Routes and Fares</h2>
    <table>
      <tr>
        <th>Travels</th>
        <th>Source</th>
        <th>Destination</th>
        <th>Bus Type</th>
        <th>Fare (Rs.)</th>
      </tr>
      <?php
      if ($db_connected) {
          $res = supabase_request('GET', '/buses?select=*&limit=5');
          if ($res['status'] == 200 && is_array($res['data']) && count($res['data']) > 0) {
              foreach($res['data'] as $row) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['name'] ?? 'N/A') . "</td>";
                  echo "<td>" . htmlspecialchars($row['source'] ?? 'N/A') . "</td>";
                  echo "<td>" . htmlspecialchars($row['destination'] ?? 'N/A') . "</td>";
                  echo "<td>" . htmlspecialchars($row['bus_type'] ?? 'N/A') . "</td>";
                  echo "<td>" . htmlspecialchars($row['fare'] ?? '0') . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>No routes found or table is empty in Supabase. Make sure you run data inserts on your Supabase dashboard!</td></tr>";
          }
      } else {
          echo "<tr><td colspan='5'>Database not connected. Please verify .env</td></tr>";
      }
      ?>
    </table>
  </div>

  <div class="footer">
    <p>Mini Project - Software Engineering</p>
    <p>Connected via Supabase</p>
  </div>

  <script src="js/main.js"></script>
</body>
</html>
