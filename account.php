<?php
include_once 'header2.php';

if (isset($_SESSION['user_name'])) {
  $name = $_SESSION['user_name'];
  $id = $_SESSION['user_id'];
}

$user = mysqli_query($conn , "SELECT * FROM user WHERE user_id = '$id'");

$row = mysqli_fetch_assoc($user);


if (isset($_POST['update'])) {
    $user_name = $_SESSION['user_name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['confirm-password']);

    if ($password == $cpassword) {
        $update_data = "UPDATE user SET email='$email', password='$password' WHERE user_name = '$user_name'";
        $update = mysqli_query($conn, $update_data);

        if ($update) {
            session_unset();
            session_destroy();
            echo "<script>alert('Account updated successfully. Please log in again.');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Failed to update account.');</script>";
        }
    } else {
        echo "<script>alert('Password not matched.');</script>";
    }
}
    
?>

?>

<!DOCTYPE html>

<html>
    
<head>
    <title>Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

</head>

<style>
    
/* Set default styles for body, headings and paragraphs */
body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  line-height: 1.5;
  margin: 0;
  padding: 0;
}

/* Style user details section */
.user_details {
  margin-top: 20px;
  margin-bottom: 60px !important;
  text-align: center;
  border: 1px solid #ccc;
  padding: 50px;
  border-radius: 5px;
  width: 40%;
  margin: 0 auto;
}

.user_details p{
    margin-bottom: 20px;
    text-transform: none;
}

/* Style account settings section */
.acc_settings {
  margin-top: 40px;
  text-align: center;
  border: 1px solid #ccc;
  padding: 50px;
  border-radius: 10px;
  width: 40%;
  margin: 0 auto;
}

.acc_settings label {
  display: block;
  font-weight: bold;
  margin-top: 30px;
}

.acc_settings input[type="email"],
.acc_settings input[type="password"] {
  padding: 10px;
  width: 350px;
  font-size: 16px;
  border-radius: 6px;
  text-align: center;
  text-transform: none;
}

.acc_settings input[type="submit"] {
  background-color: #fff;
  color: red;
  padding: 10px 20px;
  border: solid red;
  border-radius: 5px;
  margin-top: 50px;
  border-width: 1px;
  font-size: 16px;
  cursor: pointer;
}

.acc_settings input[type="submit"]:hover {
  background-color: red;
  color: white;

}

</style>

<body>
    <div style="padding-top: 80px;">
        <h1 style=" font-size: 28px; font-weight: bold; margin-bottom: 20px; text-align:center; padding: 20px;">Account Information</h1>
    </div>

        <div class="user_details">
            <h2 style="font-size: 20px; font-weight: bold; margin-top: 10px; margin-bottom: 30px;">User Details</h2>
            <p><strong>Username:</strong> <?php echo $_SESSION['user_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
         </div>
        
        <div class="acc_settings">
            <h2 style="font-size: 20px; font-weight: bold; margin-top: 10px; margin-bottom: 10px;">Update Account Settings</h2>        
            <form action="" method="POST" enctype="multipart/form-data">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
              <br>
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required>
              <br>
              <label for="confirm-password">Confirm Password:</label>
              <input type="password" id="confirm-password" name="confirm-password" required>
              <br>
              <input type="submit" name="update" value="Update Account">
            </form>
        </div>
        <br><br><br>
    </body>
</html>