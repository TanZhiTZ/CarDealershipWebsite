<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'honda');

$id = $_GET['edit'];


if(isset($_POST['update_promo'])){


    $value = $_POST['value'];
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $status = $_POST['status'];

      $update_data = "UPDATE promo SET value='$value', dateStart='$dateStart', dateEnd='$dateEnd', status='$status'  WHERE id = '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
        header("Location: promotion.php");
      }else{
         $$message[] = 'update failed'; 
      }

};

?>

<!DOCTYPE html>
<html>


    <head>
        <title>Honda Car Dealership &bull; Update Code</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/honda-icon.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>

        .add-box h2 {
            font-size: 20px;
            margin-top: 20px;
        }

        .add-box form {
            margin-top: 20px;
        }

        .add-box label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .add-box select{
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 50%;
            box-sizing: border-box;
            margin-bottom: 10px;
            text-align: center;
        }

        .add-box input[type="text"]{
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 50%;
            box-sizing: border-box;
            margin-bottom: 10px;
            text-align: center;
        }

        .add-box input[type="number"]{
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 20%;
            box-sizing: border-box;
            margin-bottom: 10px;
            text-align: center;
        }

        .add-box input[type="submit"] {
            width: 160px;
            height: 46px;
            background-color: white; 
            color: black; 
            border: 2px solid #f44336;
            border-radius: 5px;
            padding: 10px;
        }

        .add-box input[type="submit"]:hover {
            background-color: red;
            color: white;
        }

        .add-box{
            margin-left: 20px;
        }

        .delete-btn{
            display: block;
            width: 160px;
            height:46px;
            cursor: pointer;
            border-radius: 0.5rem;
            margin-top: 1rem;
            margin-left: 20px;
            font-size: 1.7rem;
            padding: 1rem 3rem;
            background-color: white; 
            color: black; 
            border: 2px solid red;
            border-radius: 5px;
            padding: 10px;
            color: var(--white);
            text-align: center;
        }

        .delete-btn:hover{
            background-color: red;
            color: white;
            transform: translateY(-2px);
        }


    </style>

    <body>

    <div style="padding: 1px; margin: 0 auto; text-align:center; margin-top: 150px;">

    <?php
        $select = mysqli_query($conn, "SELECT * FROM promo WHERE id = '$id'");
        $row = mysqli_fetch_assoc($select); // Fetch a single row

        ?>

        <div id="add-box" class="add-box" style="padding: 10px 10px; border: 1px solid; margin-top: 30px; margin-bottom: 60px; width: 50%; margin: 0 auto;">
            <h2>Update Code</h2>
                <form action="" method="post">
                        <label for="code">Promotion Code</label>
                        <input type="text" id="code" name="code" value="<?php echo $row['code'] ?>" readonly>
                        <br>
                        <label for="value">Discount Value</label>
                        <input type="number" id="value" name="value" min="0" step="0.01" value="<?php echo $row['value'] ?>" required>
                        <br>
                        <label for="dateStart">Date Start</label>
                        <input type="date" id="dateStart" name="dateStart" value="<?php echo $row['dateStart'] ?>" required>
                        <br>
                        <label for="dateEnd">Date End</label>
                        <input type="date" id="dateEnd" name="dateEnd" value="<?php echo $row['dateEnd'] ?>" required>
                        <br>
                        <label for="status">Status</label>
                        <select id="status" name="status" class="box">
                            <option value="Enabled" <?php if($row['status']=="Enabled") echo "selected='selected'" ?>>Enabled</option>
                            <option value="Disabled" <?php if($row['status']=="Disabled") echo "selected='selected'" ?>>Disabled</option>
                        </select>
                        <br>
                        <br>

                <input type="submit" name="update_promo" value="Update Code">
                <a href="promotion.php" class="delete-btn">Back</a>
             </form>
        </div>
    </div>

    <script>

        var start = document.getElementById('dateStart');
        var end = document.getElementById('dateEnd');

        start.addEventListener('change', function() {
            if (start.value)
                end.min = start.value;
        }, false);
        end.addEventLiseter('change', function() {
            if (end.value)
                start.max = end.value;
        }, false);

    </script>

    </body>
</html>