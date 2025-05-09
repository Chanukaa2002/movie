<?php
// Include database connection
include('connect.php');

// Set header to return JSON
header('Content-Type: application/json');

// Define the categories manually (just like your webpage)
$categories = [
    1 => "Hollywood",
    2 => "Bollywood",
    5 => "Kollywood"
];

$allMovies = [];

foreach ($categories as $catid => $categoryName) {
    $sql = "SELECT movies.*, categories.catname
            FROM movies
            INNER JOIN categories ON categories.catid = movies.catid
            WHERE movies.catid = $catid
            ORDER BY movies.movieid DESC";

    $res = mysqli_query($con, $sql);

    $movies = [];
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $movies[] = [
                'movieid' => $row['movieid'],
                'title' => $row['title'],
                'image' => 'admin/uploads/' . $row['image'],
                'trailer' => 'admin/uploads/' . $row['trailer'],
                'category' => $row['catname']
            ];
        }
    }

    $allMovies[] = [
        'category' => $categoryName,
        'movies' => $movies
    ];
}

// Send the final JSON response
echo json_encode([
    'status' => 'success',
    'data' => $allMovies
]);
?>
