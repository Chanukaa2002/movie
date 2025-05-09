<?php
// Include database connection
include('connect.php');

// Set header to return JSON
header('Content-Type: application/json');

// SQL Query to get theater + movie + category data
$sql = "SELECT theater.*, movies.title, movies.image, movies.trailer, categories.catname
        FROM theater
        INNER JOIN movies ON movies.movieid = theater.movieid
        INNER JOIN categories ON categories.catid = movies.catid
        ORDER BY theater.theaterid DESC";

$res = mysqli_query($con, $sql);

// Prepare data array
$theaters = [];

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $theaters[] = [
            'theater_id' => $row['theaterid'],
            'theater_name' => $row['theater_name'],
            'movie_title' => $row['title'],
            'movie_image' => 'admin/uploads/' . $row['image'],
            'trailer_link' => 'admin/uploads/' . $row['trailer'],
            'category' => $row['catname'],
            'timing' => $row['timing'],
            'days' => $row['days'],
            'date' => $row['date'],
            'location' => $row['location'],
            'price' => $row['price']
        ];
    }
}

// Send final JSON response
echo json_encode([
    'status' => 'success',
    'data' => $theaters
]);
?>
