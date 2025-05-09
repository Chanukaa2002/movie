<?php
// Include database connection
include('connect.php');

// Set the header to return JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get POST data
    $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
    $snackid = isset($_POST['snackid']) ? $_POST['snackid'] : null;
    $snackname = isset($_POST['snackname']) ? $_POST['snackname'] : null;
    $totalprice = isset($_POST['totalprice']) ? $_POST['totalprice'] : null;
    $paymentmethod = isset($_POST['paymentmethod']) ? $_POST['paymentmethod'] : null;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

    // Validate data
    if (empty($uid) || empty($snackid) || empty($snackname) || empty($totalprice) || empty($paymentmethod) || empty($quantity)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit();
    }

    // SQL Query to insert purchase record into the database
    $sql = "INSERT INTO purchases (userid, snackid, snackname, totalprice, paymentmethod, quantity) 
            VALUES ('$uid', '$snackid', '$snackname', '$totalprice', '$paymentmethod', '$quantity')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Purchase successfully recorded']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
