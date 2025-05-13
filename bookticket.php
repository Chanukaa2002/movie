<?php
include('connect.php');

// Set the header to indicate JSON response
header('Content-Type: application/json');

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);

$theaterid = $data['theaterid'];
$person = $data['person'];
$date = $data['date'];
$userid = $data['userid'];

// Insert data into the database
$sql = "INSERT INTO `booking`(`theaterid`, `bookingdate`, `person`, `userid`) 
        VALUES ('$theaterid', '$date', '$person', '$userid')";

if (mysqli_query($con, $sql)) {
    echo json_encode(['message' => 'Ticket booked successfully']);
} else {
    echo json_encode(['message' => 'Ticket booking failed']);
}
?>
