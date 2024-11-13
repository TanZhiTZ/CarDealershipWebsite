<?php
include('header2.php');

// Fetch all accessories from the database
$query = "SELECT * FROM accessory";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Accessories</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 100px; /* Adjusts space for fixed header */
            padding-bottom: 40px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            height: 200px;
            object-fit: cover;
        }
        .card-body h5 {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .card-body p {
            color: #555;
            font-size: 0.9rem;
        }
        .card-footer {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .no-accessories {
            font-size: 1.2rem;
            color: #777;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4 text-center">Available Accessories</h2>
    <div class="row justify-content-center">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <?php if ($row['image']): ?>
                            <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <?php else: ?>
                            <img src="placeholder.png" class="card-img-top" alt="No Image Available">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                        </div>
                        <div class="card-footer">
                            <span>Price: RM <?php echo number_format($row['price'], 2); ?></span>
                            <span>Quantity: <?php echo $row['quantity']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-accessories">No accessories found.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
