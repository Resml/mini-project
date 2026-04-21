<?php
require_once 'config.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['role'] === 'admin' ? "admin.php" : "index.php"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $db_connected) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $endpoint = "/users?email=eq." . urlencode($email) . "&password=eq." . urlencode($password) . "&select=id,name,role";
    $res = supabase_request('GET', $endpoint);

    if ($res['status'] == 200 && is_array($res['data']) && count($res['data']) > 0) {
        $row = $res['data'][0];
        
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'] ?? 'user';

        if ($_SESSION['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Bus Reservation</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <h1>Bus Reservation System</h1>
    <nav>
      <a href="index.php">Home</a>
    </nav>
  </header>

  <div class="container" style="max-width: 400px;">
    <h2>User / Admin Login</h2>
    
    <?php if(isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="email">Email ID:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" style="width: 100%;">Login</button>
    </form>
    <p style="margin-top: 15px; text-align: center; color: #666; font-size: 12px;">Admin use: admin@busgo.com / admin123</p>
  </div>

  <div class="footer">
    <p>Mini Project - Software Engineering</p>
  </div>
</body>
</html>
