<?php
include('connection.php');

$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;

if ($movie_id > 0) {
    $query = "SELECT poster_url FROM movies WHERE movie_id = $movie_id";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $movie = mysqli_fetch_assoc($result);
        
        $poster_path = $movie['poster_url'];
        if (file_exists($poster_path)) {
            unlink($poster_path);  
        }

        $delete_query = "DELETE FROM movies WHERE movie_id = $movie_id";
        if (mysqli_query($con, $delete_query)) {
            echo "<script>alert('Movie deleted successfully!'); window.location.href='view_movies.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='view_movies.php';</script>";
        }
    } else {
        echo "<script>alert('Movie not found!'); window.location.href='view_movies.php';</script>";
    }
} else {
    echo "<script>alert('Invalid movie ID!'); window.location.href='view_movies.php';</script>";
}

$con->close();
?>
