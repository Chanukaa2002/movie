<?php
header('Content-Type: application/json'); // important to tell Postman it's JSON

include('connect.php'); // your DB connection

// Check if search parameters are provided (optional)
$movie_search = isset($_GET['movie_search']) ? $_GET['movie_search'] : '';
$catid = isset($_GET['catid']) ? $_GET['catid'] : '';

if (!empty($movie_search) && !empty($catid)) {
    // If user provided search
    $sql = "SELECT movies.*, categories.catname 
            FROM movies 
            INNER JOIN categories ON categories.catid = movies.catid
            WHERE movies.title LIKE '%$movie_search%' AND movies.catid = '$catid'";
} else {
    // Default: return all movies
    $sql = "SELECT movies.*, categories.catname 
            FROM movies 
            INNER JOIN categories ON categories.catid = movies.catid
            ORDER BY movies.movieid DESC";
}

$res = mysqli_query($con, $sql);

$movies = [];

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $movies[] = $row;
    }
}

// Output JSON
echo json_encode([
    'status' => true,
    'data' => $movies
]);
?>
