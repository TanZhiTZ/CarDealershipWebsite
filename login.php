<?php
include('config/constants.php');
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/PHPMailer.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/SMTP.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'config/config.php';
$_SESSION['rand'] = null;

$message = "";

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = $_POST['password'];

  // Check if the email exists and get user details
  $stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND admin = '0'");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $failed_attempts = $row['failed_attempts'] ?? 0;
    $last_failed_attempt = $row['last_failed_attempt'] ?? null;

    // Calculate cooldown time if needed
    $cooldown_period = 30 * 60; // 30 minutes
    $extra_time = ($failed_attempts - 5) * 15 * 60; // 15 minutes added after 5 failed attempts
    $cooldown_time = $cooldown_period + max(0, $extra_time);
    $current_time = time();
    $unlock_time = strtotime($last_failed_attempt) + $cooldown_time;

    // Check if cooldown is active
    if ($failed_attempts >= 5 && $unlock_time > $current_time) {
      $unlock_time_formatted = date("g:i A, M j", $unlock_time);
      $message = "Too many failed attempts. You can try logging in again at $unlock_time_formatted.";
    } else {
      // Verify password
      if (password_verify($pass, $row['password'])) {
        if ($row['is_verified'] == 1) {
          // Reset failed attempts on successful login
          $reset_sql = "UPDATE `user` SET failed_attempts = 0, last_failed_attempt = NULL WHERE user_id = ?";
          $reset_stmt = $conn->prepare($reset_sql);
          $reset_stmt->bind_param("i", $row['user_id']);
          $reset_stmt->execute();

          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['user_name'] = $row['user_name'];
          $_SESSION['role'] = 'user';

          header('location:index.php');
          exit;
        } else {
          // Resend verification email
          sendVerificationEmail($email, $row['token']);
          $message = 'Your account is not verified. A new verification email has been sent.';
        }
      } else {
        // Update failed attempts and timestamp
        $failed_attempts++;
        $update_sql = "UPDATE `user` SET failed_attempts = ?, last_failed_attempt = NOW() WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $failed_attempts, $row['user_id']);
        $update_stmt->execute();
        $message = 'Incorrect email or password entered!';
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