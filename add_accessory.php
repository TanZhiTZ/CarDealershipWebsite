<?php
include('header2.php'); // Include header file

// Check if user is logged in and has the role of supplier
if (!isset($_SESSION['role_name']) || $_SESSION['role_name'] !== 'supplier') {
    // JavaScript alert for access restriction, then redirect
    echo "<script>
        alert('Access denied. Only suppliers can add accessories.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

if (isset($_POST['submit'])) {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $supplier_id = $_SESSION['user_id'];

    // Handle image upload if provided
    $image = '';
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image = 'img/' . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }

    // Insert accessory data into the database
    $stmt = $conn->prepare("INSERT INTO accessory (name, description, price, quantity, image, supplier_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisi", $name, $description, $price, $quantity, $image, $supplier_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Accessory added successfully!');
            window.location.href = 'index.php'; // Redirect to index after adding
        </script>";
    } else {
        echo "<script>alert('Error adding accessory: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Accessory</title>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .container {
            max-width: 700px;
            margin-top: 80px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-header h2 {
            color: #333;
            font-weight: 700;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-header">
        <h2>Add New Accessory</h2>
        <p class="text-muted">Please fill out the form below to add a new accessory to the catalog.</p>
    </div>

    <form action="add_accessory.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Accessory Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter accessory name">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the accessory"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price (RM) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0.01" required placeholder="Enter price">
        </div>

        <div class="form-group">
            <label for="quantity">Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required placeholder="Enter quantity available">
        </div>

        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" name="submit" class="btn btn-primary mt-3">Add Accessory</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
