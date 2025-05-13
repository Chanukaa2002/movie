<?php
include('connect.php');
header('Content-Type: application/json');

// Allow CORS (for development only)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$data = json_decode(file_get_contents("php://input"), true);

$uid = $data['userid'] ?? '';
$snackid = $data['snackid'] ?? '';
$snackname = $data['snackname'] ?? '';
$totalprice = $data['totalPrice'] ?? '';
$paymentmethod = $data['paymentMethod'] ?? '';
$quantity = $data['quantity'] ?? '';

if ($uid && $snackid && $snackname && $totalprice && $paymentmethod && $quantity) {
    $sql = "INSERT INTO purchases (userid, snackid, snackname, totalprice, paymentmethod, quantity) 
            VALUES ('$uid', '$snackid', '$snackname', '$totalprice', '$paymentmethod', '$quantity')";

    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => true, 'message' => 'Purchase successful']);
    } else {
        echo json_encode(['status' => false, 'message' => mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Invalid data']);
}
?>
