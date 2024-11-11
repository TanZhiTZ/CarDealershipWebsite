<?php

include 'config/config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User already exist';
   }else{
      if($pass != $cpass){
         $message[] = 'Password does not match!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user`(user_name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');

         if($insert){
            $message[] = 'Account Registered!';
            header('location:login.php');
         }else{
            $message[] = 'Account not registered!';
         }
      }
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
              <h2 style="color: #c90a0a; display: flex; justify-content: center; align-items: flex-end;">Register&nbsp;|&nbsp;<img src="img/honda-icon.png" alt="Honda_Logo" width="100" style="margin-bottom: 10px;"/></h2>
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
                    if(isset($message)){
                        foreach($message as $message){
                            echo '<div style="color: red; font-size: 12px; cursor: pointer;">'.$message.'</div>';
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
                <div style="width:90%"><hr color="#999999"></div>

            </form>
        </div>
      </div>

      <script src="js/main.js"></script>
    </body>
</html>
