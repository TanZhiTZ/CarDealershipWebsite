<?php
$conn = mysqli_connect('localhost', 'root', '', 'honda');

if (isset($_GET['price']) && isset($_GET['model_type'])) {
    $newPrice = $_GET['price'];
    $modelType = $_GET['model_type'];
echo $_GET['price'].$_GET['model_type'];
    // Perform the database update
    $update_query = mysqli_query($conn, "UPDATE specifications SET Price='$newPrice' WHERE ModelType='$modelType'");

    if ($update_query) {
        // Update successful

        echo "<script>alert('Price updated successfully!'); window.location.href = 'editCarPrice.php';</script>";
    } else {
        // Update failed
        echo "<script>alert('Failed to update price.'); window.location.href = 'editCarPrice.php';</script>";
    }
}
?>