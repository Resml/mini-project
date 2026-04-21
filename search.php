<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $source = $_POST['source'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $date = $_POST['date'] ?? '';
    $passengers = $_POST['passengers'] ?? 1;
} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Results - Bus Reservation</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <h1>Bus Reservation System</h1>
    <nav>
      <a href="index.php">Home</a>
    </nav>
  </header>

  <div class="container">
    <h2>Available Buses: <?php echo htmlspecialchars($source); ?> to <?php echo htmlspecialchars($destination); ?></h2>
    <p><strong>Journey Date:</strong> <?php echo htmlspecialchars($date); ?> | <strong>Passengers:</strong> <?php echo htmlspecialchars($passengers); ?></p>
    
    <table>
      <tr>
        <th>Travels</th>
        <th>Type</th>
        <th>Fare (Rs.)</th>
        <th>Total Fare</th>
        <th>Action</th>
      </tr>
      <?php
      if ($db_connected) {
          $endpoint = "/buses?source=eq." . urlencode($source) . "&destination=eq." . urlencode($destination);
          $res = supabase_request('GET', $endpoint);

          if ($res['status'] == 200 && is_array($res['data']) && count($res['data']) > 0) {
              foreach($res['data'] as $row) {
                  $total_fare = $row['fare'] * $passengers;
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['bus_type']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['fare']) . "</td>";
                  echo "<td><b>" . htmlspecialchars($total_fare) . "</b></td>";
                  echo "<td>
                          <form action='book.php' method='POST' style='margin:0;'>
                              <input type='hidden' name='bus_id' value='".htmlspecialchars($row['id'])."'>
                              <input type='hidden' name='date' value='".htmlspecialchars($date)."'>
                              <input type='hidden' name='passengers' value='".htmlspecialchars($passengers)."'>
                              <input type='hidden' name='total_amount' value='".htmlspecialchars($total_fare)."'>
                              <button type='submit' style='padding: 5px 10px; font-size: 14px;'>Book Now</button>
                          </form>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Sorry, no buses found for this route.</td></tr>";
          }
      } else {
          echo "<tr><td colspan='5'>Database Error. Cannot fetch buses.</td></tr>";
      }
      ?>
    </table>
    <br/>
    <a href="index.php" style="display:inline-block; padding: 10px 15px; background: #333; color: white; text-decoration: none; border-radius: 4px;">Back to Search</a>
  </div>

  <div class="footer">
    <p>Mini Project - Software Engineering</p>
  </div>
</body>
</html>
