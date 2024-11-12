<?php
include 'config/constants.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/PHPMailer.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/SMTP.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'config/config.php';
$_SESSION['rand'] = null;

$message = "";

date_default_timezone_set('Asia/Kuala_Lumpur');

// Function to prevent brute force by limiting attempts
function is_locked_out()
{
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

// If locked out, redirect or display a message
if (is_locked_out()) {
  die('Too many failed login attempts. Please try again in 15 minutes.');
}

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = $_POST['password'];

  // Sanitize inputs
  function sanitize_input($data)
  {
    return htmlspecialchars(stripslashes(trim($data)));
  }

  // Validate inputs (no empty fields and length within limit)
  if (empty($email) || empty($pass) || strlen($email) > 50 || strlen($pass) > 50) {
    echo '<script>alert("Invalid email or password.");</script>';
    return;
  }

  // Using prepared statements to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND admin = '0'");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if the user exists and verify password
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $failed_attempts = $row['failed_attempts'] ?? 0;
    $last_failed_attempt = $row['last_failed_attempt'];

    if (password_verify($pass, $row['password'])) {
      if ($row['is_verified'] == 1) {
        // Reset failed_attempts and last_failed_attempt after successful login
        $_SESSION['login_attempts'] = 0;  // Reset on success
        $reset_sql = "UPDATE `user` SET failed_attempts = 0, last_failed_attempt = NULL WHERE user_id = ?";
        $reset_stmt = $conn->prepare($reset_sql);
        $reset_stmt->bind_param("i", $row['user_id']);
        $reset_stmt->execute();

        // Set session variables and regenerate session ID
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $row['user_name'];
        $_SESSION['role'] = 'user';
        session_regenerate_id();

        header('location:index.php');
        exit;
      } else {
        sendVerificationEmail($email, $row['token']);
        $message = 'Your account is not verified. A new verification email has been sent.';
      }
    } else {
      // Increment login attempts on failure
      $_SESSION['login_attempts']++;
      $_SESSION['last_attempt'] = time();

      // Handle failed attempts
      if ($_SESSION['login_attempts'] >= 5) {
        $lockout_end = time() + 900; // Lockout for 15 minutes
        $formatted_time = date("g:i A", $lockout_end);
        $message = "Too many failed attempts. Account is locked. Please try again after $formatted_time.";
      } else {
        $remaining_attempts = 5 - $_SESSION['login_attempts'];
        $message = "Incorrect password. $remaining_attempts attempts remaining before lockout.";
      }
    }
  } else {
    $message = 'Incorrect email or password entered!';
  }
}

// Function to send verification email
function sendVerificationEmail($email, $token)
{
  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jerrylaw02@gmail.com';
    $mail->Password = 'zijexuiygafhswks';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('jerrylaw02@gmail.com', 'No-Reply');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';
    $mail->Body = '
            <html>
            <head>
            <title>Email Verification</title>
            </head>
            <body>
            <p>Click the link below to verify your email address:</p>
            <a href="http://localhost/Enterprise-Project-main/verification.php?token=' . $token . '">Verify Email</a>
            </body>
            </html>
        ';
    $mail->send();
  } catch (Exception $e) {
    global $message;
    $message .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
?>





<!DOCTYPE html>
<html>

<head>
  <title>Honda Car Dealership &bull; Login</title>
  <meta charset="UTF-8">
  <link rel="icon" href="img/honda-icon.png" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="no-scroll">
  <div class="bg-img">
  </div>

  <div class="bg-text" style=" display: flex;">
    <div class="login-logo-vision">
      <center>
        <a href="index.php"><img class="login-logo" src="img/honda-icon.png" alt="Honda_Logo" /></a>
      </center>
      <h3 class="logo-text">Dedication to make dealing faster and easier</h3>
    </div>

    <div class="frame" align="middle">
      <form action="#" method="POST" enctype="multipart/form-data">
        <div class="field">
          <input type="email" class="textbox" name="email" placeholder="Email" required="required" autofocus>
        </div>
        <div class="field">
          <input type="password" class="textbox" name="password" placeholder="Password" id="pass" required="required">
        </div>
        <?php
        if (!empty($message)) {
          echo '<div style="color: red; font-size: 12px; cursor: pointer;">' . $message . '</div>';
        }
        ?>
        <br />
        <div class="field">
          <button class="btn-login hover-container" name="submit" type="submit">
            <div class="overlay"></div>
            <b>Log In</b>
          </button>
        </div>

        <div style="width:90%">
          <hr color="#999999">
        </div>

        <a href="register.php" class="btn-register" style="font-family:'verdana'; padding: 10px 30px;"><b>Create an Account</b></a>
      </form>
    </div>
  </div>

  <script src="js/main.js"></script>
</body>

</html>