<?php
$conn = mysqli_connect('localhost', 'root', '', 'honda');

if(isset($_GET['id'])){
    $id = $_GET['id'];
};

// Fetch model information with prepared statements for security
$modelStmt = $conn->prepare("SELECT * FROM carinformation WHERE id = ?");
$modelStmt->bind_param("i", $id);
$modelStmt->execute();
$model = $modelStmt->get_result();

// Fetch specifications
$specStmt = $conn->prepare("SELECT * FROM specifications WHERE ModelId = ?");
$specStmt->bind_param("i", $id);
$specStmt->execute();
$spec = $specStmt->get_result();

// Fetch stock details ordered by specId
$stockStmt = $conn->prepare("SELECT * FROM stock WHERE modelId = ? ORDER BY specId");
$stockStmt->bind_param("i", $id);
$stockStmt->execute();
$stock = $stockStmt->get_result();

if (isset($_POST['add_stock'])) {
    $modelId = $_POST['modelId'];
    $specId = $_POST['specId'];
    $specModel = $_POST['specModel'];
    $color = $_POST['color'];
    $stockAmount = $_POST['stock'];

    // Duplicate entry check
    $checkDuplicateStmt = $conn->prepare("SELECT * FROM stock WHERE specId = ? AND specModel = ? AND color = ?");
    $checkDuplicateStmt->bind_param("iss", $specId, $specModel, $color);
    $checkDuplicateStmt->execute();
    $checkDuplicate = $checkDuplicateStmt->get_result();

    if ($checkDuplicate->num_rows > 0) {
        header("Location: viewStock.php?id=$id&error=duplicate");
        exit;
    } else {
        // Insert new stock
        $insertStmt = $conn->prepare("INSERT INTO stock (modelId, specId, specModel, color, stock) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("iissi", $modelId, $specId, $specModel, $color, $stockAmount);
        
        if ($insertStmt->execute()) {
            header("Location: viewStock.php?id=$id&message=success");
        } else {
            echo "<script>alert('Could not add the stock');</script>";
        }
    }
}

if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $deleteStmt = $conn->prepare("DELETE FROM stock WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    echo "<script>window.location.replace('viewStock.php?id=$id&message=deleted');</script>";
}

// Display alerts
if (isset($_GET['error']) && $_GET['error'] === 'duplicate') {
    echo "<script>alert('A stock with the same Model Type already exists.');</script>";
}
if (isset($_GET['message']) && $_GET['message'] === 'success') {
    echo "<script>alert('New stock added successfully.');</script>";
}
if (isset($_GET['message']) && $_GET['message'] === 'deleted') {
    echo "<script>alert('Stock deleted successfully.');</script>";
}
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
            width: 200px;
            height: 50px;
            font-size: 18px;
        }

        .add-stock:hover {
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


        .stock-display{
            margin:2rem 0;
            margin-bottom: 100px;
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


    </style>

    <body onload="sidebarHeight()">

    <div id="sideHeight" class="flex-shrink-0 p-4 bg-white" style="width: 200px; min-height:100%; float:left;">
        <span class="fs-5 fw-semibold">Admin</span>
        <hr style="border-bottom: 2px solid; border-top: none; margin: 10px 0 10px 0;"/>
        <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
            Home
            </button>
            <div class="collapse show" id="home-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="adminIndex.php" class="link-dark rounded">Dashboard</a></li>
                <li><a href="stockList.php" class="link-dark rounded">Stock List</a></li>
                <li><a href="promotion.php" class="link-dark rounded">Promotion Code</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="true">
            Analytics
            </button>
            <div class="collapse show" id="dashboard-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="soldOverview.php" class="link-dark rounded">Overview</a></li>
                <li><a href="monthlySold.php" class="link-dark rounded">Monthly</a></li>
                <li><a href="allMonthlySold.php" class="link-dark rounded">All Month</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="true">
            Orders
            </button>
            <div class="collapse show" id="orders-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="prebooklist.php" class="link-dark rounded">Bookings</a></li>
                <li><a href="soldHistory.php" class="link-dark rounded">History</a></li>
            </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#manage-collapse" aria-expanded="true">
            Manage Cars
            </button>
            <div class="collapse show" id="manage-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="addcar.php" class="link-dark rounded">Add Car</a></li>
                <li><a href="addSpec.php" class="link-dark rounded">Add Spec</a></li>
                <li><a href="editCarPrice.php" class="link-dark rounded">Edit Price</a></li>
                <li><a href="stock.php" class="link-dark rounded">Edit Stock</a></li>
            </ul>
            </div>
        </li>
        <li class="border-top my-3"></li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="true">
            Account
            </button>
            <div class="collapse show" id="account-collapse" style="">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="config/adminLogout.php" class="link-dark rounded">Sign out</a></li>
            </ul>
            </div>
        </li>
        </ul>
    </div>

        <div style="padding: 1px; margin-left: 250px; text-align:center;">
            <h1 align="center" style="margin-top: 50px; margin-bottom: 50px;">
                <?php while ($row = mysqli_fetch_assoc($model)) {
                    echo $row['model']; 
                }
                ?>
                Stock
            </h1>

            <button type="submit" class="add-stock" onclick="addStock();">Create New Stock</button><br>
            <a href="stock.php">
            <button type="submit" class="add-stock">Switch Model</button>
            </a>
                <div id="add-box" class="add-box" style="display: none; padding: 10px 10px; border: 1px solid; width: 50%; margin: 50px auto;">
                    <button type="submit" class="hide" onclick="hideBox();">X</button>
                    <h2>Create New Stock</h2>
                    <form action="" method="post">
                        <input type="hidden" name="modelId" id="modelId" value="<?php echo $id?>">
                        <label for="specModel">Model Type</label>
                        <select name="specId" id="specId" required>
                            <?php while ($row = mysqli_fetch_array($spec)): ?>
                                <option value="<?php echo $row['Id']; ?>"><?php echo $row['ModelType']; ?></option>
                            <?php endwhile; ?>
                        </select>
                         <!-- Hidden input field outside of the select -->
                        <input type="hidden" name="specModel" id="specModel" value="">
                        <br>
                        <label for="color">Color</label>
                        <input type="text" id="color" name="color" required>
                        <br>
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" min="0" value="0" required>
                        <br>
                        <br>

                        <input type="submit" name="add_stock" value="Add Stock" style="margin-bottom: 30px;">
                    </form>
                </div>
                <br>
                <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search">

                <div class="stock-display">
                    <h1 style="color:black; padding-top: 50px; padding-bottom: 50px;">Stock Lists</h1>
                    <table class="stock-display-table" id="stock-table">
                        <thead>
                        <tr>
                            <th>Model Type</th>
                            <th>Color</th>
                            <th>Stock</th>
                            <th>Edit/Delete</th>
                        </tr>
                        </thead>
                        <?php while($row = mysqli_fetch_assoc($stock)){ ?>
                        <tr>
                            <td><?php echo $row['specModel']; ?></td>
                            <td><?php echo $row['color']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td>
                            <a href="updateStock.php?edit=<?php echo $row['id'];?>&id=<?php echo $id;?>" class="edit-btn"> <i class="fas fa-edit"></i> Edit </a>
                            <a href="viewStock.php?delete=<?php echo $row['id'];?>&id=<?php echo $id;?>" class="delete-btn"> <i class="fas fa-trash"></i> Delete </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
        </div>

        <script>

        function sidebarHeight() {
            var body = document.body,
            html = document.documentElement;

            var fullHeight = Math.max( body.scrollHeight, body.offsetHeight, 
                                html.clientHeight, html.scrollHeight, html.offsetHeight );
            
            document.getElementById("sideHeight").style.height = fullHeight + "px";
        }

            function addStock() {
            document.getElementById("add-box").style.display = "block";
            }
            
            function hideBox() {
                document.getElementById("add-box").style.display = "none";
            }

            document.getElementById("specId").addEventListener("change", function () {
                var select = this;
                var selectedOption = select.options[select.selectedIndex];
                var modelValue = selectedOption.text;
                console.log("Selected Value:", modelValue); // Debugging
                document.getElementById("specModel").value = modelValue;
                console.log("Hidden Input Value:", document.getElementById("specModel").value); // Debugging
            });

            document.getElementById("specId").dispatchEvent(new Event("change"));

            function myFunction() {
                // Declare variables
                var input, filter, table, tr, td, i, j, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("stock-table");
                tr = table.getElementsByTagName("tr");

                // Start looping from the second row (index 1)
                for (i = 1; i < tr.length; i++) {
                    // Loop through all table columns
                    var found = false;
                    for (j = 0; j < 3; j++) {  // Assuming you have 3 columns (Model Type, Color, Stock)
                        td = tr[i].getElementsByTagName("td")[j];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break;  // Break out of the column loop if a match is found
                            }
                        }
                    }
                    // Show or hide the row based on whether a match was found in any column
                    if (found) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        </script>

    </body>
</html>