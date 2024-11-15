<?php include('config/constants.php'); ?>
<?php
include 'config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $sender_name = "Honda Penang";
    $subject = "[Honda] Prebooking Summary";

    $name_form = $_POST['form_name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $payment_method = $_POST['payment_method'];
    $variant = $_POST['variant'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $date = date('Y-m-d');
    $name = $_POST['user_name'];
    $user_id = $_POST['user_id'];

    $prebook_query = "INSERT INTO `prebook`(name, email, contact, paymentmethod, model, color, price, account, date, user_id) VALUES" . "('$name_form', '$email','$contact_no','$payment_method','$variant','$color','$price', '$name', '$date', '$user_id')";
    $prebook_result = mysqli_query($conn, $prebook_query) or die("Select query failed");

    if ($prebook_query) {
        // Predefined recipient email address
        $to = $email; // Replace with the recipient email address

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration for Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jerrylaw02@gmail.com'; // Replace with your Gmail email address
            $mail->Password = 'zijexuiygafhswks'; // Replace with your Gmail account password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set sender and recipient information
            $mail->setFrom($email, $sender_name);
            $mail->addAddress($to);

            // Set email subject and body
            $mail->Subject = $subject;
            //$mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
            $mail->Body = " Dear $name_form,\n\n Prebooking Summary\n ==============\n Contact:+60$contact_no\n Model:$variant\n Your Color:$color\n Car Price(To be paid):RM$price\n Account:$name\n\n\n Note:Look for online customer service(bottom right) to cancel the prebooking.";

            // Send the email
            $mail->send();

            // Email sent successfully
            echo "<script>alert('Prebook done. Prebook summary sent to your email.'); window.location.href = 'index.php';</script>";
            //header("Location: Contact.php");
        } catch (Exception $e) {
            // Error occurred while sending email
            echo "Sorry, an error occurred while sending the email. Error: " . $mail->ErrorInfo;
        }
    }
} else {
    // Handle non-POST requests, redirect back to the form page
    header("Location: index.php");
    exit;
}
?>