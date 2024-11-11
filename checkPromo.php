<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $promoCode = $_POST['coupon_code'];
    // Connect to your database (replace these with your database details)
    $conn = mysqli_connect('localhost', 'root', '', 'honda');

    // Check if the promotion code is valid and meets the conditions
    $query = "SELECT * FROM promo WHERE code = '$promoCode' AND status = 'Enabled' AND NOW() BETWEEN dateStart AND dateEnd";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    if ($row) {
        echo json_encode(array(
            "statusCode" => 200,
            "value" => $row['value']
        ));
    } else {
        echo json_encode(array("statusCode" => 201));
    }
}
    
?>