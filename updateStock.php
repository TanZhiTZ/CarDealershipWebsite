<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'honda');

$editId = $_GET['edit']; 
$m_id = $_GET['id'];


if(isset($_POST['update_stock'])){


    $stock = $_POST['stock'];

      $update_data = "UPDATE stock SET  stock='$stock' WHERE id = '$editId'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
        header("Location: viewStock.php?id=$m_id");
      }else{
         $$message[] = 'update failed'; 
      }

};

?>

<!DOCTYPE html>
<html>


    <head>
        <title>Honda Car Dealership &bull; View Stock</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/honda-icon.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>
        
        .add-stock{
            background-color: black; 
            color:#fff; 
            border-radius: 5px; 
            padding: 10px 10px; 
            margin-bottom: 30px;
        }

        .add-stock:hover {
            background-color: red;
            -webkit-transform: translateY(-55px);
            -ms-transform: translateY(-5px);
            transform: translateY(-5px);
        }


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


        .stock-display{
            margin:2rem 0;
        }

        .stock-display .stock-display-table{
            width: 70%;
            margin: 0 auto;
            text-align: center;
            border-width: 1px;
            border-style: solid;
            border-color: black;
        }

        .stock-display .stock-display-table thead{
            background: #fff;
        }

        .stock-display .stock-display-table th{
            padding:1rem;
            font-size: 2rem;
        }


        .stock-display .stock-display-table td{
            padding:1rem;
            font-size: 1rem;
            border-bottom: var(--border);
        }

        .stock-display .stock-display-table .btn:first-child{
            margin-top: 0;
        }

        .stock-display .stock-display-table .btn:last-child{
            background: crimson;
        }

        .stock-display .stock-display-table .btn:last-child:hover{
            background: var(--black);
        }

        .edit-btn {
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
            border: 2px solid #59EA76;
            border-radius: 5px;
            padding: 10px;
            color: var(--white);
            text-align: center;
        }

        .edit-btn:hover{
            background-color: #59EA76;
            transform: translateY(-2px);
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
        $select = mysqli_query($conn, "SELECT * FROM stock WHERE id = '$editId'");
        $row = mysqli_fetch_assoc($select); // Fetch a single row

        ?>

        <div id="add-box" class="add-box" style="padding: 10px 10px; border: 1px solid; margin-top: 30px; margin-bottom: 60px; width: 50%; margin: 0 auto;">
            <h2>Update Stock</h2>
            <form action="" method="post">
                <input type="hidden" name="modelId" id="modelId" value="<?php echo $m_id ?>">
                <label for="specModel">Model Type</label>
                <input type="text" id="specModel" name="specModel" value="<?php echo $row['specModel'] ?>" readonly>
                <br>
                <label for="color">Color</label>
                <input type="text" id="color" name="color" value="<?php echo $row['color'] ?>" readonly>
                <br>
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" min="0" value="<?php echo $row['stock'] ?>" required>
                <br>
                <br>

                <input type="submit" name="update_stock" value="Update Stock">
                <a href="viewStock.php?id=<?php echo $m_id?>" class="delete-btn">Back</a>
            </form>
        </div>
    </div>

    </body>
</html>