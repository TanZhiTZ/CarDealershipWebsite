<?php
$conn = mysqli_connect('localhost', 'root', '', 'honda');
include 'adminSidebar.php';

$model = mysqli_query($conn, "SELECT * FROM carinformation order by id asc");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Honda Car Dealership &bull; Stock</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/honda-icon.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-sm-3 {
        flex: 0 0 calc(25% - 20px); 
        margin: 10px; 
        border: 1px;
        border-style: solid;
        border-color: black;
        background: #ffffff;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    </style>

    <body onload="sidebarHeight()">

    <div style="padding: 1px; margin-left: 250px;">
        <h1 align="center" style="margin-top: 30px; margin-bottom: 30px;">Add Stock for Model:</h1>
        <div class="row">
        <?php 
            while ($row = mysqli_fetch_assoc($model)) {
                echo "
                    <div class='col-sm-3 p-3'>
                        <a href='viewStock.php?id={$row['id']}'>
                            <img src='img/{$row['model']}/{$row['homeimage']}' alt='Model Image'/>
                            <p style='text-align: center;'>{$row['model']}</p>
                        </a>
                    </div>";
            }
        ?>
        </div>
    </div>
    
    </body>
</html>