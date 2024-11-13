<?php
include 'config/config.php';

require 'C:/xampp/htdocs/PHPMailer-6.8.0/src/PHPMailer.php';
require 'C:/xampp/htdocs/PHPMailer-6.8.0/src/SMTP.php';
require 'C:/xampp/htdocs/PHPMailer-6.8.0/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];

    // Check if the password meets the required pattern
    if (!preg_match('/^(?=.*[a-zA-Z])(?=.*[\W_]).{6,}$/', $pass)) {
        $message[] = 'Password must be at least 6 characters long and include at least one letter and one special character.';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT user_id, is_verified, token FROM `user` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $existing_user = $result->fetch_assoc();

        if ($existing_user) {
            if (!$existing_user['is_verified']) {
                // Resend verification email
                sendVerificationEmail($email, $existing_user['token']);
                $message[] = 'Your account is not verified. A new verification email has been sent.';
            } else {
                $message[] = 'Email already exists. Please use a different email.';
            }
        } else {
            if ($pass != $cpass) {
                $message[] = 'Passwords do not match!';
            } else {
                $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(50)); // Generate a unique token
                $isVerified = 0; // Initial verification status
                $role_id = 1; // Set role_id to 1 for default user role

                // Insert new user securely with role_id
                $stmt = $conn->prepare("INSERT INTO `user` (user_name, email, password, token, is_verified, role_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssii", $name, $email, $hashed_pass, $token, $isVerified, $role_id);

                if ($stmt->execute()) {
                    // Send verification email
                    sendVerificationEmail($email, $token);
                    $message[] = 'Account registered! Verification email has been sent.';
                    header('location:login.php'); // Redirect after message
                    exit;
                } else {
                    $message[] = 'Account not registered!';
                }
            }
        }
    }
}


function sendVerificationEmail($email, $token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jerrylaw02@gmail.com';
        $mail->Password   = 'zijexuiygafhswks';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('jerrylaw02@gmail.com', 'Car Dealership Website');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body    = '
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
        $message[] = "Verification email could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

    <div class="bg-text" style=" display: flex; flex-direction: column; align-items: center;">

        <div class="frame" align="middle">
            <form action="#" method="POST" enctype="multipart/form-data">
                <h2 style="color: #c90a0a; display: flex; justify-content: center; align-items: flex-end;">Register&nbsp;|&nbsp;<img src="img/honda-icon.png" alt="Honda_Logo" width="100" style="margin-bottom: 10px;" /></h2>
                </br>
                <div class="field">
                    <input type="name" class="textbox" name="name" placeholder="User Name" required="required" autofocus>
                </div>
                <div class="field">
                    <input type="email" class="textbox" name="email" placeholder="Email" required="required">
                </div>
                <div class="field">
                    <input type="password" class="textbox" name="password" placeholder="Password" id="pass" required="required">
                </div>
                <div class="field">
                    <input type="password" class="textbox" name="cpassword" placeholder="Confirm Password" id="cpass" required="required">
                </div>
                <?php
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div style="color: red; font-size: 12px; cursor: pointer;">' . $message . '</div>';
                    }
                }
                ?>
                <div class="field">
                    <button class="btn-register" name="submit" type="submit">
                        <b>Register</b>
                    </button>
                </div>
                <div class="field">
                    <a style="font-family:'verdana'" href="login.php">Already have an account?</a>
                </div>
                <div style="width:90%">
                    <hr color="#999999">
                </div>

            </form>
        </div>
    </div>

    <script src="js/main.js"></script>
</body>

</html>