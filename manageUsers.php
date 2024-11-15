<?php
include 'adminSidebar.php';
$conn = mysqli_connect('localhost', 'root', '', 'honda');

// Check if user is logged in and has the role of Super Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    echo "<script>
        alert('Access denied. Only Super Admins can access this page.');
        window.location.href = 'adminIndex.php';
    </script>";
    exit;
}

// Fetch user data if editing
$user_data = null;
if (isset($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];
    $query = "SELECT * FROM `user` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($conn, $query);
    $user_data = mysqli_fetch_assoc($result);
}

// Add new user
if (isset($_POST['add_user'])) {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $admin = $_POST['admin'] == 'super_admin' ? 2 : ($_POST['admin'] == 'yes' ? 1 : 0); // 2 for Super Admin, 1 for Admin, 0 for regular user
    $failed_attempts = 0;
    $last_failed_attempt = NULL;
    $token = NULL;
    $is_verified = 0;
    $role_id = $_POST['role_id'];

    $add_query = "INSERT INTO `user` (`user_name`, `email`, `password`, `admin`, `failed_attempts`, `last_failed_attempt`, `token`, `is_verified`, `role_id`) 
                  VALUES ('$user_name', '$email', '$password', '$admin', '$failed_attempts', '$last_failed_attempt', '$token', '$is_verified', '$role_id')";
    if (mysqli_query($conn, $add_query)) {
        echo "User added successfully!";
    } else {
        echo "Error adding user: " . mysqli_error($conn);
    }
}

// Update user
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $admin = $_POST['admin'] == 'super_admin' ? 2 : ($_POST['admin'] == 'yes' ? 1 : 0);
    $is_verified = $_POST['is_verified'] == 'yes' ? 1 : 0;
    $role_id = $_POST['role_id'];

    $update_query = "UPDATE `user` SET `user_name` = '$user_name', `email` = '$email', `admin` = '$admin', `is_verified` = '$is_verified', `role_id` = '$role_id' WHERE `user_id` = $user_id";
    if (mysqli_query($conn, $update_query)) {
        echo "User updated successfully!";
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}

// Delete user
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_query = "DELETE FROM `user` WHERE `user_id` = $user_id";
    if (mysqli_query($conn, $delete_query)) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            background-color: #007BFF;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .form-container, .user-list {
            margin-top: 30px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-list th, .user-list td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        .user-list th {
            background-color: #007BFF;
            color: white;
        }
        .action-links a {
            margin-right: 10px;
            color: #007BFF;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Manage Users</h1>
        </div>

        <!-- Add/Edit User Form -->
        <div class="form-container">
            <h2><?php echo $user_data ? 'Edit User' : 'Add User'; ?></h2>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_data['user_id'] ?? ''; ?>">
                <input type="text" name="user_name" placeholder="User Name" value="<?php echo $user_data['user_name'] ?? ''; ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo $user_data['email'] ?? ''; ?>" required>
                <input type="password" name="password" placeholder="Password (Leave blank to keep the same)">
                <select name="admin">
                    <option value="no" <?php echo isset($user_data) && $user_data['admin'] == 0 ? 'selected' : ''; ?>>Not Admin</option>
                    <option value="yes" <?php echo isset($user_data) && $user_data['admin'] == 1 ? 'selected' : ''; ?>>Admin</option>
                    <option value="super_admin" <?php echo isset($user_data) && $user_data['admin'] == 2 ? 'selected' : ''; ?>>Super Admin</option>
                </select>
                <select name="is_verified">
                    <option value="no" <?php echo isset($user_data) && $user_data['is_verified'] == 0 ? 'selected' : ''; ?>>Not Verified</option>
                    <option value="yes" <?php echo isset($user_data) && $user_data['is_verified'] == 1 ? 'selected' : ''; ?>>Verified</option>
                </select>
                <select name="role_id">
                    <option value="1" <?php echo isset($user_data) && $user_data['role_id'] == 1 ? 'selected' : ''; ?>>User</option>
                    <option value="2" <?php echo isset($user_data) && $user_data['role_id'] == 2 ? 'selected' : ''; ?>>Supplier</option>
                    <option value="3" <?php echo isset($user_data) && $user_data['role_id'] == 3 ? 'selected' : ''; ?>>Banned</option>
                </select>
                <button type="submit" name="add_user" <?php echo isset($user_data) ? 'style="display:none"' : ''; ?>>Add User</button>
                <button type="submit" name="update_user" <?php echo isset($user_data) ? '' : 'style="display:none"'; ?>>Update User</button>
            </form>
        </div>

        <!-- User List -->
        <div class="user-list">
            <h2>User List</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Verified</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM `user`";
                    $result = mysqli_query($conn, $query);
                    while ($user = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <?php
                            // Display admin role based on the admin field
                            if ($user['admin'] == 2) echo 'Super Admin';
                            elseif ($user['admin'] == 1) echo 'Admin';
                            else echo 'No';
                            ?>
                        </td>
                        <td><?php echo $user['is_verified'] == 1 ? 'Yes' : 'No'; ?></td>
                        <td>
                            <?php
                            if ($user['role_id'] == 1) echo 'User';
                            elseif ($user['role_id'] == 2) echo 'Supplier';
                            elseif ($user['role_id'] == 3) echo 'Banned';
                            ?>
                        </td>
                        <td>
                            <a href="?edit_user=<?php echo $user['user_id']; ?>">Edit</a>
                            <a href="?delete_user=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>