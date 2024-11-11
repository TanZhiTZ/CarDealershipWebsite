<?php
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/PHPMailer.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/SMTP.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $sender_name = "Honda Penang";
    $subject = "[Honda] Test Drive Reservation Summary";

    // Initialize an empty array to store the data from the form
    $form_data = array();

    // Loop through the data and extract it based on the counter
    for ($counter = 1; isset($_POST['name' . $counter]); $counter++) {

        if (isset($_POST['send' . $counter])) {
            $data = array(
                'id' => $_POST['id' . $counter],
                'name' => $_POST['name' . $counter],
                'email' => $_POST['email' . $counter],
                'contact' => $_POST['contact' . $counter],
                'test_model' => $_POST['testdrivemodel' . $counter],
                'user_account' => $_POST['user' . $counter],
                'note' => $_POST['note' . $counter],
                'preferred_date' => $_POST['preferred_date' . $counter],
                'preferred_time' => $_POST['preferred_time' . $counter],
            );
            // Add the data to the form_data array
            $form_data[] = $data;
        }

    }

    foreach ($form_data as $data) {
        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];
        $contact = $data['contact'];
        $test_model = $data['test_model'];
        $preferred_date = $data['preferred_date'];
        $preferred_time = $data['preferred_time'];
        $user_account = $data['user_account'];
        $note = $data['note'];




        // $name = $_POST['name'];
        // $email = $_POST['email'];
        // $contact = $_POST['contact'];
        // $test_model = $_POST['testdrivemodel'];
        // $preferred_date = $_POST['preferred_date'];
        // $preferred_time = $_POST['preferred_time'];
        // $user_account = $_POST['user'];
        // $note = $_POST['note'];


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
            $mail->Body = " Dear $name,\n\n Booking Summary\n ==============\n Contact:+60$contact\n Test Drive Model:$test_model\n Your Preferred Date:$preferred_date\n Your Preferred time:$preferred_time\n Account:$user_account\n\n\n Note:$note";

            // Send the email
            $mail->send();

            // Email sent successfully
            echo "<script>alert('Name: $name. Email sent to $email'); window.location.href = 'testdrivelist.php';</script>";
            //header("Location: Contact.php");
        } catch (Exception $e) {
            // Error occurred while sending email
            echo "Sorry, an error occurred while sending the email. Error: " . $mail->ErrorInfo;
        }
    }
} else {
    // Handle non-POST requests, redirect back to the form page
    header("Location: testdrivelist.php");
    exit;
}
?>