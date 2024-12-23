<?php
include 'adminSidebar.php';
$conn = mysqli_connect('localhost', 'root', '', 'honda');

$promo = mysqli_query($conn, "SELECT * FROM promo order by id");

$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$total_promo = mysqli_query($conn, "SELECT COUNT(id) AS count FROM promo");
$total_count = mysqli_fetch_assoc($total_promo)['count'];
$total_pages = ceil($total_count / $limit);

$promo = mysqli_query($conn, "SELECT * FROM promo ORDER BY id LIMIT $start, $limit");


if (isset($_POST['add_promo'])) {
    $code = $_POST['code'];
    $value = $_POST['value'];
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $status = $_POST['status'];

    // Check if a record with the same specId, specModel, and color exists
    $checkDuplicate = mysqli_query($conn, "SELECT * FROM promo WHERE code = '$code'");

    if (mysqli_num_rows($checkDuplicate) > 0) {
        header("Location: promotion.php?error=duplicate");
        exit; // Add exit here to stop the script execution
    } else {
        // Insert the new stock
        $insert = "INSERT INTO promo (code, value, dateStart, dateEnd, status) 
            VALUES ('$code', '$value', '$dateStart', '$dateEnd', '$status')";
        
        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            $message[] = 'New stock added successfully';
            header("Location: promotion.php");
        } else {
            $message[] = 'Could not add the stock';
        }
    }
}

if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM promo WHERE id = $deleteId");
    echo "<script>window.location.replace('promotion.php');</script>";
}

// Display an alert for duplicate entry
if (isset($_GET['error']) && $_GET['error'] === 'duplicate') {
    echo "<script>alert('Code already exists.');</script>";
}


?>

<!DOCTYPE html>
<html>


    <head>
        <title>Honda Car Dealership &bull; Promotion</title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/honda-icon.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <style>
        
        .add-promo{
            background-color: black; 
            color:#fff; 
            border-radius: 5px; 
            padding: 10px 10px; 
            margin-bottom: 30px;
            width: 300px;
            height: 50px;
            font-size: 18px;
        }

        .add-promo:hover {
            background-color: red;
            -webkit-transform: translateY(-55px);
            -ms-transform: translateY(-5px);
            transform: translateY(-5px);
        }

        .hide{
            background-color: red; 
            color:#fff; 
            border-radius: 5px; 
            padding: 10px 10px; 
            margin-bottom: 30px;
            float: right;
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

        .add-box input[type="date"]{
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


        .promo-display{
            margin:2rem 0;
            margin-bottom: 100px;
        }

        .promo-display .promo-display-table{
            width: 90%;
            margin: 0 auto;
            text-align: center;
            border-width: 1px;
            border-style: solid;
            border-color: black;
        }

        .promo-display .promo-display-table thead{
            background: #fff;
        }

        .promo-display .promo-display-table th{
            padding:1rem;
            font-size: 2rem;
        }


        .promo-display .promo-display-table td{
            padding:1rem;
            font-size: 1rem;
            border-bottom: var(--border);
        }

        .promo-display .promo-display-table .btn:first-child{
            margin-top: 0;
        }

        .promo-display .promo-display-table .btn:last-child{
            background: crimson;
        }

        .promo-display .promo-display-table .btn:last-child:hover{
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

        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 12px; 
            background-repeat: no-repeat;
            width: 60%; 
            margin: 50px auto;
            font-size: 16px; 
            padding: 12px 20px 12px 40px; 
            border: 1px solid #ddd; 
            margin-bottom: 12px; 
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
        }

        .pagination a.active {
            background-color: red;
            color: white;
        }

        .pagination a:hover:not(.active) {background-color: #ddd;}

    </style>

    <body>
        <div style="padding: 1px; margin-left: 250px; text-align:center;">
            <h1 align="center" style="margin-top: 50px; margin-bottom: 50px;">Promotion</h1>

            <button type="submit" class="add-promo" onclick="addCode();">Create New Promotion Code</button><br>

                <div id="add-box" class="add-box" style="display: none; padding: 10px 10px; border: 1px solid; width: 50%; margin: 50px auto;">
                    <button type="submit" class="hide" onclick="hideBox();">X</button>
                    <h2>Create New Promotion Code</h2>
                    <form action="" method="post">
                        <label for="code">Promotion Code</label>
                        <input type="text" id="code" name="code" required>
                        <br>
                        <label for="value">Discount Amount</label>
                        <input type="number" id="value" name="value" min="0" step="0.01" value="0" required>
                        <br>
                        <label for="dateStart">Date Start</label>
                        <input type="date" id="dateStart" name="dateStart" required>
                        <br>
                        <label for="dateEnd">Date End</label>
                        <input type="date" id="dateEnd" name="dateEnd" required>
                        <br>
                        <label for="status">Status</label>
                        <select id="status" name="status" class="box">
                            <option value="Enabled">Enabled</option>
                            <option value="Disabled">Disabled</option>
                        </select>
                        <br>
                        <br>

                        <input type="submit" name="add_promo" value="Add Code" style="margin-bottom: 30px;">
                    </form>
                </div>
                <br>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search">

                <div class="promo-display">
                    <h1 style="color:black; padding-top: 50px; padding-bottom: 50px;">Promotion Codes</h1>
                    <table class="promo-display-table" id="promo-table">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Discount Amount</th>
                            <th>Date Start</th>
                            <th>Date End</th>
                            <th>Status</th>
                            <th>Edit/Delete</th>
                        </tr>
                        </thead>
                        <?php while($row = mysqli_fetch_assoc($promo)){ ?>
                        <tr>
                            <td><?php echo $row['code']; ?></td>
                            <td>RM <?php echo $row['value']; ?></td>
                            <td><?php echo $row['dateStart']; ?></td>
                            <td><?php echo $row['dateEnd']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                            <a href="updatePromo.php?edit=<?php echo $row['id'];?>" class="edit-btn"> <i class="fas fa-edit"></i> Edit </a>
                            <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['id']; ?>)" class="delete-btn"> <i class="fas fa-trash"></i> Delete </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
        </div>
        
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="promotion.php?page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php endfor; ?>
        </div>

        <script>

            function addCode() {
            document.getElementById("add-box").style.display = "block";
            }
            
            function hideBox() {
                document.getElementById("add-box").style.display = "none";
            }

            function myFunction() {
                var input = document.getElementById("myInput");
                var filter = input.value.toUpperCase();
                var table = document.getElementById("promo-table");
                var tr = table.getElementsByTagName("tr");

                for (let i = 1; i < tr.length; i++) {
                    tr[i].style.display = "none";
                    let td = tr[i].getElementsByTagName("td");
                    for (let j = 0; j < td.length; j++) {
                        if (td[j]) {
                            let txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                break;
                            }
                        }
                    }
                }
            }

            function confirmDelete(id) {
                if (confirm("Are you sure you want to delete this promotion code?")) {
                    window.location.href = "promotion.php?delete=" + id;
                }
            }

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