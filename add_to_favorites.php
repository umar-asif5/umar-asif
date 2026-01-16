<?php
// Include the database connection
include('connection.php');

// Start the session to access user_id
session_start();

// Check if the user is logged in
if (isset($_POST['user_id']) && isset($_POST['movie_id'])) {
    $user_id = $_POST['user_id'];
    $movie_id = $_POST['movie_id'];

    // Check if the movie is already in the user's favorites
    $check_sql = "SELECT * FROM favorites WHERE user_id = $user_id AND movie_id = $movie_id";
    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Movie is already in favorites
        echo "Movie already in your favorites.";
    } else {
        // Insert the movie into the favorites table
        $insert_sql = "INSERT INTO favorites (user_id, movie_id) VALUES ($user_id, $movie_id)";
        
        if (mysqli_query($con, $insert_sql)) {
            echo "Movie added to favorites!";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    echo "Invalid request.";
}
?>
