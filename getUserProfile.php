<?php
// Include database connection
include('connect.php');

// Set header to return JSON
header('Content-Type: application/json');

// Check if the user ID is provided in the GET request
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
    echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
    exit();
}

$uid = $_GET['uid'];

// SQL Query to get user profile details
$sql = "SELECT * FROM `users` WHERE userid = '$uid'";

// Execute query
$res = mysqli_query($con, $sql);

// Check if user exists
if (mysqli_num_rows($res) > 0) {
    $user_data = mysqli_fetch_assoc($res);
    
    // Return user profile data as JSON
    echo json_encode([
        'status' => 'success',
        'user_data' => [
            'userid' => $user_data['userid'],
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => $user_data['password']
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>
