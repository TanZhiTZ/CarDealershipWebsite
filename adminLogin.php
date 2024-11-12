<?php
include 'config/constants.php';

ini_set('display_errors', 0);

// Function to prevent brute force by limiting attempts
function is_locked_out() {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt'] = time();
    }
    
    if ($_SESSION['login_attempts'] >= 5 && time() - $_SESSION['last_attempt'] < 900) {
        return true; // Lockout for 15 minutes
    }
    
    if (time() - $_SESSION['last_attempt'] >= 900) {
        // Reset attempts after 15 minutes
        $_SESSION['login_attempts'] = 0;
    }
    
    return false;
}

// Sanitize and validate input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// If locked out, redirect or display a message
if (is_locked_out()) {
    die('Too many failed login attempts. Please try again in 15 minutes.');
}

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $user = sanitize_input($_POST['user']);
    $pass = sanitize_input($_POST['password']);
    
    // no empty inputs and length within 50
    if (empty($user) || empty($pass) || strlen($user) > 50 || strlen($pass) > 50) {
        echo '<script>alert("Invalid username or password.");</script>';
        return;
    }

    // using prepare to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, user_name FROM user WHERE user_name = ? AND admin = '1'");
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and verify password
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      
      // passwords are hashed using password_hash bcrypt
      if (password_verify($pass, $row['password'])) {
          // Reset attempts on successful login
          $_SESSION['login_attempts'] = 0;

          // Set session variables and regenerate session ID
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['user_name'] = $row['user_name'];
          $_SESSION['role'] = 'admin';
          session_regenerate_id();

          header('Location: adminIndex.php');
          exit;
      } else {
          echo '<script>alert("Incorrect password.");</script>';
      }
  } else {
      echo '<script>alert("Username does not exist or you are not an admin.");</script>';
  }

  // Increment login attempts on failure
  $_SESSION['login_attempts']++;
  $_SESSION['last_attempt'] = time();

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Honda Car Dealership &bull; Admin Login</title>
    <meta charset="UTF-8">
    <link rel="icon" href="img/honda-icon.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="no-scroll">
    <div class="bg-img"></div>

    <div class="adm-bg-text" style="display: flex;">
        <div class="adm-frame">
            <h3>Admin Login</h3>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <input type="text" class="adm-textbox" name="user" placeholder="Admin Username" required maxlength="50">
                </div>
                <div class="field">
                    <input type="password" class="adm-textbox" name="password" placeholder="Password" required maxlength="50">
                </div>
                <div class="field">
                    <button class="adm-btn-login" name="submit" type="submit"><b>Log In</b></button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>
</html>
