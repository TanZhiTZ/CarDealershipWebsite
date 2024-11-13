<?php
include('config/constants.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

include 'config/config.php';
$_SESSION['rand'] = null;

$message = "";

date_default_timezone_set('Asia/Kuala_Lumpur');

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND admin = '0'");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $failed_attempts = $row['failed_attempts'] ?? 0;
    $last_failed_attempt = $row['last_failed_attempt'];

    // Fixed lockout time of 15 minutes
    $lockout_minutes = 15;

    $current_time = new DateTime('now', new DateTimeZone('Asia/Kuala_Lumpur'));
    $lockout_end = null;

    // Check if the user is currently in a lockout period
    if ($failed_attempts >= 5 && $last_failed_attempt !== null) {
      $last_attempt_time = new DateTime($last_failed_attempt, new DateTimeZone('Asia/Kuala_Lumpur'));
      $lockout_end = clone $last_attempt_time;
      $lockout_end->add(new DateInterval("PT{$lockout_minutes}M"));

      // Check if the current time is before the lockout end time
      if ($current_time < $lockout_end) {
        $formatted_time = $lockout_end->format("g:i A");
        $message = "Account is locked. Please try again after $formatted_time.";
      }
    }

    if (empty($message)) {
      // Verify password if not in lockout
      if (password_verify($pass, $row['password'])) {
        if ($row['is_verified'] == 1) {
          // Reset failed_attempts and last_failed_attempt after successful login
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
          sendVerificationEmail($email, $row['token']);
          $message = 'Your account is not verified. A new verification email has been sent.';
        }
      } else {
        // Increment failed_attempts and update last_failed_attempt
        $failed_attempts++;
        $update_sql = "UPDATE `user` SET failed_attempts = ?, last_failed_attempt = NOW() WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $failed_attempts, $row['user_id']);
        $update_stmt->execute();

        // Handle failed attempts
        if ($failed_attempts >= 5) {
          $lockout_end = clone $current_time;
          $lockout_end->add(new DateInterval("PT{$lockout_minutes}M"));
          $formatted_time = $lockout_end->format("g:i A");
          $message = "Too many failed attempts. Account is locked. Please try again after $formatted_time.";
        } else {
          $remaining_attempts = 5 - $failed_attempts;
          $message = "Incorrect password. $remaining_attempts attempts remaining before lockout.";
        }
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