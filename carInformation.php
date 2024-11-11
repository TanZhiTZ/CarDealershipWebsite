<?php
include_once 'header2.php';
?>

<?php
       $model = isset($_GET['model']) ? $_GET['model'] : die();

        if (isset($_SESSION['user_name'])) {
          $user_id = $_SESSION['user_id'];
          $name = $_SESSION['user_name'];
        }


        $sql = "SELECT * FROM carinformation WHERE model='$model'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count>0) {
          while($row=mysqli_fetch_assoc($res)) {
            $homeimage = $row['homeimage'];
            $modelinformation = $row['modelinformation'];
            $modelpic = $row['modelpic'];
            $specpic1 = $row['specpic1'];
            $specpic2 = $row['specpic2'];
            $specpic3 = $row['specpic3'];
            $designpic1 = $row['designpic1'];
            $designpic2 = $row['designpic2'];
            $designpic3 = $row['designpic3'];
            $designpic4 = $row['designpic4'];
            $specdesc1 = $row['specdesc1'];
            $specdesc2 = $row['specdesc2'];
            $specdesc3 = $row['specdesc3'];
            $designdesc1 = $row['designdesc1'];
            $designdesc2 = $row['designdesc2'];
            $designdesc3 = $row['designdesc3'];
            $designdesc4 = $row['designdesc4'];
          }
        }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Honda Car Dealership &bull; Car Information</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body id="grad" style="padding-top: 100px;">
      <!--car model-->
      <div class="main">
        <?php echo'<img src="img/'.$model.'/'.$modelpic.'" class="car-model" alt="Honda Accord"/>';?>
        <div>
          <h3><b><?php echo "$model";?></b></h3>
        </div>
        <div style="width: 50%; text-align: center;">
          <p><?php echo "$modelinformation";?></p>
        </div>

      </br><hr style="width: 90%;"/></br></br>

      <!--car specification-->
      
      <?php
        echo '
          <div class="row align-items-center" style="width: 85%;">
            <div class="col">
              <img src="img/'.$model.'/'.$specpic1.'" class="car-spec" alt="Honda Accord"/>
            </div>
            <div class="col">
              <img src="img/'.$model.'/'.$specpic2.'" class="car-spec" alt="Honda Accord"/>
            </div>
            <div class="col">
              <img src="img/'.$model.'/'.$specpic3.'" class="car-spec" alt="Honda Accord"/>
            </div>
          </div></br>

          <div class="row align-items-center" style="width: 85%; font-size:18px;">
            <div class="col">
            '.$specdesc1.'
            </div>
            <div class="col">
            '.$specdesc2.'
            </div>
            <div class="col">
            '.$specdesc3.'
            </div>
          </div>';

        ?>

</br></br>
</br></br>
        <!--interior design-->
        <div class="container" style="width: 76%; font-size: 24px;">

        <?php
            echo '
          <div class="row align-items-center">
            <div class="col">
            '.$designdesc1.'
            </div>
            <div class="col">
              <img src="img/'.$model.'/'.$designpic1.'" width="auto" height="400"/>
            </div>
          </div>
          </br>
          <div class="row align-items-center">
            <div class="col">
              <img src="img/'.$model.'/'.$designpic2.'" width="auto" height="400"/>
            </div>
            <div class="col">
            '.$designdesc2.'
            </div>
          </div>
          </br>
          <div class="row align-items-center">
            <div class="col">
            '.$designdesc3.'
            </div>
            <div class="col">
              <img src="img/'.$model.'/'.$designpic3.'" width="auto" height="400"/>
            </div>
          </div>
          </br>
          <div class="row align-items-center">
            <div class="col">
              <img src="img/'.$model.'/'.$designpic4.'" width="auto" height="400"/>
            </div>
            <div class="col">
            '.$designdesc4.'
            </div>
          </div>';
          ?>

          </br>
        </div>
        </br>

        <!--Pricing-->
        <div class="row">
          <div class="col">
            <button class="btn-car-model hover-container" name="submit" type="submit">
                <div class="btn-car-model-overlay"></div>
                <a href="comparison.php"><b style="color:white;">Specification &amp; Pricing</b></a>
            </button>
            <button class="btn-car-model hover-container" name="submit" type="submit">
                <div class="btn-car-model-overlay"></div>
                <a href="prebookvariant.php?model=<?php echo"$model";?>"><b style="color:white;">Book your own car now!</b></a>
            </button>
          </div>
        </div>

</br></br></br>
      </div>
    </body>
</html>
