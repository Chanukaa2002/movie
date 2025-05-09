<?php
// Include database connection
include('connect.php');

// Set content type to JSON for API responses
header('Content-Type: application/json');

// Check if the required parameters are provided
if(isset($_POST['movie_search']) || isset($_POST['catid'])) {
    $movie_search = isset($_POST['movie_search']) ? $_POST['movie_search'] : '';
    $catid = isset($_POST['catid']) ? $_POST['catid'] : '';

    // Build the SQL query based on provided filters
    if (!empty($movie_search) && !empty($catid)) {
        $sql = "SELECT movies.*, categories.catname 
                FROM movies
                INNER JOIN categories ON categories.catid = movies.catid
                WHERE movies.title LIKE '%$movie_search%' AND movies.catid = '$catid'";
    } elseif (!empty($movie_search)) {
        $sql = "SELECT movies.*, categories.catname 
                FROM movies
                INNER JOIN categories ON categories.catid = movies.catid
                WHERE movies.title LIKE '%$movie_search%'";
    } elseif (!empty($catid)) {
        $sql = "SELECT movies.*, categories.catname 
                FROM movies
                INNER JOIN categories ON categories.catid = movies.catid
                WHERE movies.catid = '$catid'";
    } else {
        $sql = "SELECT movies.*, categories.catname 
                FROM movies
                INNER JOIN categories ON categories.catid = movies.catid
                ORDER BY movies.movieid DESC";
    }

    // Execute the query
    $res = mysqli_query($con, $sql);

    // Check if any results are found
    if (mysqli_num_rows($res) > 0) {
        $movies = [];
        while ($data = mysqli_fetch_array($res)) {
            $movies[] = [
                'movieid' => $data['movieid'],
                'title' => $data['title'],
                'image' => 'admin/uploads/' . $data['image'], // Image path
                'trailer' => 'admin/uploads/' . $data['trailer'], // Trailer path
                'category' => $data['catname'],
            ];
        }

        // Return movies data in JSON format
        echo json_encode([
            'status' => 'success',
            'movies' => $movies
        ]);
    } else {
        // If no movies are found
        echo json_encode([
            'status' => 'error',
            'message' => 'No movies found'
        ]);
    }
} else {
    // If parameters are missing
    echo json_encode([
        'status' => 'error',
        'message' => 'Required parameters missing (movie_search or catid)'
    ]);
}
?>
