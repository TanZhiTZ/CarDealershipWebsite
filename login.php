<?php include('config/constants.php'); ?>
<?php

include 'config/config.php';
$_SESSION['rand'] = null;

if(isset($_POST['submit'])){
 
 $email = mysqli_real_escape_string($conn, $_POST['email']);
 $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

 $select = mysqli_query($conn, "SELECT * FROM `user` WHERE email = '$email' AND password = '$pass' AND admin = '0'") or die('query failed');

 if(mysqli_num_rows($select) > 0){
    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['user_name'] = $row['user_name'];
    header('location:index.php');
 }else{
    $message[] = 'Incorrect email or password entered!';
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
            <a href="index.php"><img class="login-logo" src="img/honda-icon.png" alt="Honda_Logo"/></a>
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
                if(isset($message)) {
                  foreach($message as $message) {
                    echo '<div style="color: red; font-size: 12px; cursor: pointer;">'.$message.'</div>';
                  }
                }
              ?>
              <br/>
                 <div class="field">
                     <button class="btn-login hover-container" name="submit" type="submit">
                         <div class="overlay"></div>
                       <b>Log In</b>
                     </button>
                </div>
                
                <div style="width:90%"><hr color="#999999"></div>

                <a href="register.php" class="btn-register" style="font-family:'verdana'; padding: 10px 30px;"><b>Create an Account</b></a>
            </form>
        </div>
      </div>

      <script src="js/main.js"></script>
    </body>
</html>
