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

// SQL Query to get booking details
$booking_sql = "SELECT booking.bookingid, booking.bookingdate, booking.person, theater.theater_name, theater.timing, theater.days, theater.price, theater.location, movies.title, categories.catname, users.name AS 'username', booking.status
                FROM booking
                INNER JOIN theater ON theater.theaterid = booking.theaterid
                INNER JOIN users ON users.userid = booking.userid
                INNER JOIN movies ON movies.movieid = theater.movieid
                INNER JOIN categories ON categories.catid = movies.catid
                WHERE booking.userid = '$uid'";

// Execute booking query
$booking_res = mysqli_query($con, $booking_sql);

// Prepare the booking data array
$booking_data = [];
if (mysqli_num_rows($booking_res) > 0) {
    while ($row = mysqli_fetch_assoc($booking_res)) {
        $booking_data[] = [
            'booking_id' => $row['bookingid'],
            'theater_name' => $row['theater_name'],
            'movie_title' => $row['title'],
            'category' => $row['catname'],
            'date' => $row['bookingdate'],
            'time' => $row['timing'],
            'days' => $row['days'],
            'price' => $row['price'],
            'location' => $row['location'],
            'username' => $row['username'],
            'status' => $row['status'] == 0 ? 'Pending' : 'Approved'
        ];
    }
} else {
    $booking_data = null;
}

// SQL Query to get purchase details
$purchase_sql = "SELECT purchases.snackid, snacks.snackname, purchases.totalprice, purchases.paymentmethod, purchases.purchase_date, purchases.quantity
                 FROM purchases
                 INNER JOIN snacks ON snacks.snackid = purchases.snackid
                 WHERE purchases.userid = '$uid'";

// Execute purchase query
$purchase_res = mysqli_query($con, $purchase_sql);

// Prepare the purchase data array
$purchase_data = [];
if (mysqli_num_rows($purchase_res) > 0) {
    while ($row = mysqli_fetch_assoc($purchase_res)) {
        $purchase_data[] = [
            'snack_name' => $row['snackname'],
            'total_price' => $row['totalprice'],
            'payment_method' => $row['paymentmethod'],
            'purchase_date' => $row['purchase_date'],
            'quantity' => $row['quantity']
        ];
    }
} else {
    $purchase_data = null;
}

// Return both booking and purchase data as JSON response
echo json_encode([
    'status' => 'success',
    'booking_data' => $booking_data,
    'purchase_data' => $purchase_data
]);

?>
