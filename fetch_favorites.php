<?php
session_start();
include('connection.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  
    // Fetch favorite movies
    $sql_new = "
        SELECT m.title, f.movie_id
        FROM favorites f
        INNER JOIN movies m ON f.movie_id = m.movie_id
        WHERE f.user_id = $user_id
    ";
  
    $result_new = mysqli_query($con, $sql_new);
  
    // Check if any favorites were found
    if (mysqli_num_rows($result_new) > 0) {
        $favorites = [];
        while ($row = mysqli_fetch_assoc($result_new)) {
            $favorites[] = [
                'title' => $row['title'],
                'movie_id' => $row['movie_id']
            ];
        }
        echo json_encode($favorites);  // Return the data as a JSON response
    } else {
        echo json_encode([]);  // No favorites, return an empty array
    }
} else {
    echo json_encode([]);  // No user logged in
}
?>
