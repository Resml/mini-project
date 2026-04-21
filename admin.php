<?php
require_once 'config.php';

// Protect Admin Route
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Add New Bus Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_bus']) && $db_connected) {
    $payload = [
        'name' => $_POST['name'],
        'source' => $_POST['source'],
        'destination' => $_POST['destination'],
        'bus_type' => $_POST['bus_type'],
        'fare' => (float)$_POST['fare']
    ];

    $res = supabase_request('POST', '/buses', $payload);
    if ($res['status'] >= 200 && $res['status'] < 300) {
        $success = "New bus added successfully!";
    } else {
        $error = "Error adding bus.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel - Bus Reservation</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <h1>Admin Panel - Bus Reservation</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <div style="margin-top: 20px;">
      <h3>Recent Bookings</h3>
      <table>
        <tr>
          <th>Booking Ref</th>
          <th>User ID</th>
          <th>Bus ID</th>
          <th>Date</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
        <?php
        if ($db_connected) {
            // Simplified fetch. For foreign keys to cleanly map `users(name),buses(name)` we fetch raw IDs instead to avoid REST syntax issues if tables not setup perfectly.
            $res = supabase_request('GET', '/bookings?select=booking_reference,user_id,bus_id,journey_date,total_amount,status&order=booking_date.desc&limit=10');
            
            if ($res['status'] == 200 && is_array($res['data']) && count($res['data']) > 0) {
                foreach($res['data'] as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['booking_reference'] ?? 'N/A') . "</td>";
                    echo "<td>User #" . htmlspecialchars($row['user_id'] ?? '') . "</td>";
                    echo "<td>Bus #" . htmlspecialchars($row['bus_id'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['journey_date'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_amount'] ?? '0') . "</td>";
                    echo "<td>" . htmlspecialchars($row['status'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No bookings found.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Database connection failed.</td></tr>";
        }
        ?>
      </table>
    </div>
  </div>

  <div class="container">
    <h2>Add New Bus</h2>
    <form action="admin.php" method="POST">
      <input type="hidden" name="add_bus" value="1">
      <div class="form-group">
        <label>Bus Name / Travels:</label>
        <input type="text" name="name" required>
      </div>
      <div class="form-group">
        <label>Source:</label>
        <input type="text" name="source" required>
      </div>
      <div class="form-group">
        <label>Destination:</label>
        <input type="text" name="destination" required>
      </div>
      <div class="form-group">
        <label>Bus Type:</label>
        <select name="bus_type">
          <option>A/C Sleeper</option>
          <option>Non A/C Sleeper</option>
          <option>A/C Seater</option>
          <option>Non A/C Seater</option>
        </select>
      </div>
      <div class="form-group">
        <label>Base Fare (Rs.):</label>
        <input type="number" name="fare" min="100" step="10" required>
      </div>
      <button type="submit">Add Bus Details</button>
    </form>
  </div>

  <div class="footer">
    <p>Admin Dashboard</p>
  </div>
</body>
</html>
