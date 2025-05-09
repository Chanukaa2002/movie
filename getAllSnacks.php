<?php
// Include database connection
include('connect.php');

// Set header to return JSON
header('Content-Type: application/json');

// SQL Query to get snack data
$sql = "SELECT * FROM `snacks` ORDER BY snackid DESC";
$res = mysqli_query($con, $sql);

// Prepare an array to store snack data
$snacks = [];

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $snacks[] = [
            'snack_id' => $row['snackid'],
            'snack_name' => $row['snackname'],
            'snack_image' => 'admin/uploads/' . $row['image'],
            'snack_price' => $row['price']
        ];
    }
}

// Send JSON response
echo json_encode([
    'status' => 'success',
    'data' => $snacks
]);
?>
