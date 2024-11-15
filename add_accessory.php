<?php
include('header2.php'); // Include header file

// Check if user is logged in and has the role of supplier
if (!isset($_SESSION['role_name']) || $_SESSION['role_name'] !== 'supplier') {
    echo "<script>
        alert('Access denied. Only suppliers can access this page.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $supplier_id = $_SESSION['user_id'];

    $image = '';
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image = 'img/' . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            echo "<script>alert('Failed to upload image.');</script>";
        }
    }

    $stmt = $conn->prepare("INSERT INTO accessory (name, description, price, quantity, image, supplier_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisi", $name, $description, $price, $quantity, $image, $supplier_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Accessory added successfully!');
            window.location.href = 'add_accessory.php';
        </script>";
    } else {
        echo "<script>alert('Error adding accessory: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Handle editing an existing accessory
if (isset($_POST['edit_submit'])) {
    $accessory_id = $_POST['accessory_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Check if a new image is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image = 'img/' . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            $stmt = $conn->prepare("UPDATE accessory SET name=?, description=?, price=?, quantity=?, image=? WHERE accessory_id=?");
            $stmt->bind_param("ssdisi", $name, $description, $price, $quantity, $image, $accessory_id);
        } else {
            echo "<script>alert('Failed to upload image');</script>";
        }
    } else {
        $stmt = $conn->prepare("UPDATE accessory SET name=?, description=?, price=?, quantity=? WHERE accessory_id=?");
        $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $accessory_id);
    }

    if ($stmt->execute()) {
        echo "<script>
            alert('Accessory updated successfully!');
            window.location.href = 'add_accessory.php';
        </script>";
    } else {
        echo "<script>alert('Error updating accessory');</script>";
    }

    $stmt->close();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_stmt = $conn->prepare("DELETE FROM accessory WHERE accessory_id = ?");
    $delete_stmt->bind_param("i", $delete_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    header("Location: add_accessory.php");
}

$result = $conn->query("SELECT * FROM accessory");
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

    <h3 class="mt-5">All Accessories</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['accessory_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($row['image']); ?>" width="50"></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editAccessory(<?php echo $row['accessory_id']; ?>)">Edit</button>
                        <a href="add_accessory.php?delete=<?php echo $row['accessory_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Accessory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAccessoryForm" action="add_accessory.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accessory_id" id="editAccessoryId">
                    <div class="form-group">
                        <label for="editName">Accessory Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editPrice">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="editQuantity">Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="editImage">Upload New Image</label>
                        <input type="file" class="form-control-file" id="editImage" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="edit_submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function editAccessory(accessoryId) {
        $.ajax({
            url: 'get_accessory.php',
            type: 'GET',
            data: { id: accessoryId },
            success: function(response) {
                const data = JSON.parse(response);
                $('#editAccessoryId').val(data.accessory_id);
                $('#editName').val(data.name);
                $('#editDescription').val(data.description);
                $('#editPrice').val(data.price);
                $('#editQuantity').val(data.quantity);
                $('#editModal').modal('show');
            },
            error: function() {
                alert("Error retrieving accessory data.");
            }
        });
    }
</script>
</body>
</html>
