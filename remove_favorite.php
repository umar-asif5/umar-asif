<?php
session_start();
include('connection.php');

if (isset($_SESSION['user_id']) && isset($_POST['movie_id'])) {
    $user_id = $_SESSION['user_id'];
    $movie_id = $_POST['movie_id'];

    // Remove movie from the favorites table
    $sql = "DELETE FROM favorites WHERE user_id = $user_id AND movie_id = $movie_id";

    if (mysqli_query($con, $sql)) {
        echo 'success';  // Send success response back to AJAX
    } else {
        echo 'error';  // Send error response back to AJAX
    }
} else {
    echo 'error';  // If no valid session or movie_id, send error
}
?>
