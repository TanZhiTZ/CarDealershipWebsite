<?php include('config/constants.php'); ?>
<?php

include 'config/config.php';
$_SESSION['rand'] = null;

if(isset($_POST['submit'])){
 
 $user = mysqli_real_escape_string($conn, $_POST['user']);
 $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

 $select = mysqli_query($conn, "SELECT * FROM `user` WHERE user_name = '$user' AND password = '$pass' AND admin = '1'") or die('query failed');
 if(mysqli_num_rows($select) > 0){
  $row = mysqli_fetch_assoc($select);
  $_SESSION['user_id'] = $row['user_id'];
  $_SESSION['user_name'] = $row['user_name'];
  header('location:adminIndex.php');
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

     <div class="adm-bg-text" style=" display: flex;">

        <div class="adm-frame">
          <h3>Admin Login</h3>
          <br/>
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="field">
                    <input type="user" class="adm-textbox" name="user" placeholder="Admin" required="required" autofocus>
                </div>
                <div class="field">
                    <input type="password" class="adm-textbox" name="password" placeholder="Password" id="pass" required="required">
                </div>
              <br/>
                 <div class="field">
                     <button class="adm-btn-login" name="submit" type="submit">
                       <b>Log In</b>
                     </button>
                </div>
            </form>
        </div>
      </div>

      <script src="js/main.js"></script>
    </body>
</html>
