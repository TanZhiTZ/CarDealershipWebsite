<?php
include('config/constants.php');

if (isset($_GET['id'])) {
    $accessory_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM accessory WHERE accessory_id = ?");
    $stmt->bind_param("i", $accessory_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $accessory = $result->fetch_assoc();
        echo json_encode($accessory);
    } else {
        echo json_encode(['error' => 'Accessory not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No accessory ID provided']);
}

$conn->close();
?>
