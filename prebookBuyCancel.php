<?php include('config/constants.php'); ?>
<?php
include 'config/config.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/PHPMailer.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/SMTP.php';
require 'D:/xampp/htdocs/PHPMailer-6.8.0/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $sender_name = "Honda Penang";

    // Initialize an empty array to store the data from the form
    $form_data = array();

    // Loop through the data and extract it based on the counter
    for ($counter = 1; isset($_POST['name' . $counter]); $counter++) {

        if (isset($_POST['book' . $counter])) {
            $data = array(
                'name' => $_POST['name' . $counter],
                'email' => $_POST['email' . $counter],
                'contact' => $_POST['contact' . $counter],
                'model' => $_POST['model' . $counter],
                'color' => $_POST['color' . $counter],
                'payment_method' => $_POST['paymentmethod' . $counter],
                'price' => $_POST['price' . $counter],
                'date' => $_POST['date' . $counter],
                'user_account' => $_POST['account' . $counter],
                'id' => $_POST['id' . $counter],
                'is_cancel' => isset($_POST['cancel' . $counter]) ? 1 : 0,
                // Check if the checkbox is selected

            );
            // Add the data to the form_data array
            $form_data[] = $data;
        }

    }

    foreach ($form_data as $data) {
        $name = $data['name'];
        $email = $data['email'];
        $contact = $data['contact'];
        $model = $data['model'];
        $color = $data['color'];
        $payment_method = $data['payment_method'];
        $price = $data['price'];
        $date = $data['date'];
        $user_account = $data['user_account'];
        $id = $data['id'];
        $is_cancel = $data['is_cancel'];

        //If the cancel checkbox is not ticked
        if ($is_cancel != 1) {
            //Get the stock num based on model and color.
            $stock_check_query = "SELECT * from stock WHERE specModel = '$model' AND color = '$color'";
            $stock_result = mysqli_query($conn, $stock_check_query) or die("Select query failed");

            if ($stock_result) {
                $row = mysqli_fetch_assoc($stock_result);
                $stock_num = $row['stock']; //Store the stock number

                //If the car no have stock, send email to notify user and delete the prebook automatically
                if ($stock_num == 0) {
                    $cancel_query = "DELETE from prebook where id = '$id'";
                    $cancel_result = mysqli_query($conn, $cancel_query);

                    if ($cancel_result) {
                        $subject = "[Honda] Prebook Cancellation ($model Out of Stock) ";
                        $to = $email;
                        $mail = new PHPMailer(true);
                        try {
                            // SMTP configuration for Gmail
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'jerrylaw02@gmail.com'; //Sender email
                            $mail->Password = 'zijexuiygafhswks'; //Sender password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            // Set sender and recipient information
                            $mail->setFrom($email, $sender_name);
                            $mail->addAddress($to);

                            // Set email subject and body
                            $mail->Subject = $subject;

                            //$mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
                            $mail->Body = " Dear $name,\n\n Prebook Cancellation\n =================\nAccount:$user_account\nYour prebook for $model color $color is cancelled due to out of stock.\n\nNote:Sorry for inconvenience.";

                            // Send the email
                            $mail->send();

                            // Email sent successfully
                            echo "<script>alert('OUT OF STOCK id:$id, for $model $color. Email sent to $email '); window.location.href = 'prebooklist.php';</script>";
                            
                        } catch (Exception $e) {
                            // Error occurred while sending email
                            echo "Sorry, an error occurred while sending the email. Error: " . $mail->ErrorInfo;
                        }
                    } else {
                        echo "<script>alert('Prebook car fail to cancel'); window.location.href = 'prebooklist.php';</script>";
                    }
                    // echo "<script>alert('id:$id, Car:$model, Color:$color no stock');window.location.href = 'prebooklist.php'; </script>";
                    return;
                } else {
                    // echo "<script>alert('id:$id, Car:$model, Color:$color, Stock:$stock_num');window.location.href = 'prebooklist.php'; </script>";
                    //minus the stock number
                    $stock_num = $stock_num - 1;
                    $stock_update_query = "UPDATE stock SET stock = '$stock_num' WHERE specModel= '$model' AND color = '$color'";
                    $update_result = mysqli_query($conn, $stock_update_query) or die('Update query failed');

                    if ($update_result) {
                        //Save the details to the history table
                        $insert = "INSERT INTO `history`(name, email, contact, model, color, paymentmethod, price, account, date) VALUES" . "('$name', '$email','$contact','$model','$color','$payment_method','$price', '$user_account', '$date')" or die('query failed');
                        $result = mysqli_query($conn, $insert) or die('Insert query failed');

                        // Check if the insert was successful
                        if ($result) {
                            // Perform the delete operation in prebook based on id
                            $delete = "DELETE FROM prebook WHERE id= '$id'";
                            $delete_result = mysqli_query($conn, $delete) or die('Delete query failed');

                            if ($delete_result) {
                                $subject = "[Honda] Purchase Summary";

                                // Predefined recipient email address
                                $to = $email;

                                // Create a new PHPMailer instance
                                $mail = new PHPMailer(true);

                                try {
                                    // SMTP configuration for Gmail
                                    $mail->isSMTP();
                                    $mail->Host = 'smtp.gmail.com';
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'jerrylaw02@gmail.com'; // Replace with  Gmail email address
                                    $mail->Password = 'zijexuiygafhswks'; // Replace with  Gmail account password
                                    $mail->SMTPSecure = 'tls';
                                    $mail->Port = 587;

                                    // Set sender and recipient information
                                    $mail->setFrom($email, $sender_name);
                                    $mail->addAddress($to);

                                    // Set email subject and body
                                    $mail->Subject = $subject;
                                    //$mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
                                    $mail->Body = " Dear $name,\n\n Purchase Summary\n ==============\n Contact:+60$contact\n Model:$model\n Color:$color\n Date:$date\n Pay by:$payment_method\n Price:RM $price\n Account:$user_account\n";

                                    // Send the email
                                    $mail->send();

                                    // Email sent successfully
                                    // echo "<script>alert('Car sold and $id prebook deleted and Email sent');window.location.href = 'prebooklist.php';</script>";
                                    //header("Location: Contact.php");
                                } catch (Exception $e) {
                                    echo "Sorry, an error occurred while sending the email. Error: " . $mail->ErrorInfo;
                                }

                                //Get the stock id
                                $get_stockId = "SELECT id FROM stock WHERE specModel = '$model' AND color = '$color'";
                                $res2 = mysqli_query($conn, $get_stockId);
                                $count2 = mysqli_num_rows($res2);

                                if($count2>0){
                                    while ($row = mysqli_fetch_array($res2)) {
                                        $stockId = $row['id'];
                                    }
                                }

                                //increase the sold num in carsold table
                                $month = date('m');
                                $year = date('Y');
                                $select_sold = "SELECT * FROM carsold WHERE specModel = '$model' AND color = '$color' AND year = '$year' AND month = '$month'";
                                $res = mysqli_query($conn, $select_sold);
                                $count = mysqli_num_rows($res);

                                //check if the model, color, year and month is exist, if yes then update the soldnum
                                if ($count) {
                                    while ($row = mysqli_fetch_array($res)) {
                                        $sold = $row['soldnum'];
                                    }

                                    //update the sold number + 1
                                    $sold = $sold + 1;
                                    $update_sold = "UPDATE carsold set soldnum = '$sold', stockId = '$stockId' WHERE specModel = '$model' AND color = '$color' AND year = '$year' AND month = '$month'";
                                    $update_sold_result = mysqli_query($conn, $update_sold);

                                    if ($update_sold_result) {
                                        echo "<script>alert('UPDATE $id: $model $color sold on $month $date');window.location.href = 'prebooklist.php';</script>";
                                    } else {
                                        echo "<script>alert('Failed to update sold num');</script>";
                                    }
                                } else { //if no then insert into the carsold table
                                    $sold = 1;
                                    $insert_sold = "INSERT INTO `carsold`(specModel, color, soldnum, price, year, month, stockId)VALUES" . "('$model', '$color', '$sold', '$price', '$year', '$month', '$stockId')";
                                    $insert_sold_result = mysqli_query($conn, $insert_sold);

                                    if ($insert_sold_result) {
                                        echo "<script>alert('INSERT $id: $model $color sold on $month $date');window.location.href = 'prebooklist.php';</script>";
                                    } else {
                                        echo "<script>alert('Failed to insert carsold'); window.location.href = 'prebooklist.php';</script>";
                                    }
                                }

                            } else {
                                echo "Failed to delete associated record";
                            }
                        } else {
                            echo "Failed to insert data into 'history' table";
                        }

                    }


                }
            }

        } else {
            //
            //If checkbox == 1, cancel prebooking
            //delete the prebook based on id.
            $cancel_query = "DELETE from prebook where id = '$id'";
            $cancel_result = mysqli_query($conn, $cancel_query);

            //Send cancelllation email.
            if ($cancel_result) {
                $subject = "[Honda] Prebook Cancellation ";
                $to = $email;
                $mail = new PHPMailer(true);
                try {
                    // SMTP configuration for Gmail
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'jerrylaw02@gmail.com'; //Sender email
                    $mail->Password = 'zijexuiygafhswks'; //Sender password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Set sender and recipient information
                    $mail->setFrom($email, $sender_name);
                    $mail->addAddress($to);

                    // Set email subject and body
                    $mail->Subject = $subject;
                    //$mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";
                    $mail->Body = " Dear $name,\n\n Prebook Cancellation\n =================\nAccount:$user_account\nYour prebook for $model color $color is cancelled successfully.\n\nNote:You will not receive your booking fee as penalty.";

                    // Send the email
                    $mail->send();

                    // Email sent successfully
                    echo "<script>alert('id:$id, $email has cancel the prebooking for $model $color'); window.location.href = 'prebooklist.php'; window.location.href = 'prebooklist.php';</script>";
                    //header("Location: Contact.php");
                } catch (Exception $e) {
                    // Error occurred while sending email
                    echo "Sorry, an error occurred while sending the email. Error: " . $mail->ErrorInfo;
                }
                // echo "<script>alert('Prebook car cancelled'); window.location.href = 'prebooklist.php';</script>";
            } else {
                echo "<script>alert('Prebook car fail to cancel'); window.location.href = 'prebooklist.php';</script>";
            }

        }
    } //end for each




} else {
    // Handle non-POST requests, redirect back to the form page
    header("Location: testdrivelist.php");
    exit;
}
?>