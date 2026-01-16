<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #000; 
    color: red; 
    margin: 0;
    padding: 0;
}

.movie-details {
    padding: 20px;
    margin: 20px auto;
    max-width: 900px;
    background-color: #333; 
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
}

.movie-title {
    color: white;
    font-size: 32px;
    margin-bottom: 15px;
    text-align: center;
}

.movie-description {
    font-size: 18px;
    color: #f4f4f4;
    margin-bottom: 15px;
}

.reviews-section {
    margin-top: 40px;
    max-width: 900px;
    margin-left: auto;
    margin-right: auto;
    padding: 20px;
    background-color: #222; 
    border-radius: 10px;
}

.review {
    background-color: #444; 
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
}

.review-author {
    font-size: 20px;
    color: white; 
    margin-bottom: 10px;
}

.review-comment {
    font-size: 16px;
    color: #e0e0e0; 
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .movie-details, .reviews-section {
        padding: 15px;
        margin: 10px;
    }

    .movie-title {
        font-size: 28px;
    }

    .review-author {
        font-size: 18px;
    }

    .review-comment {
        font-size: 14px;
    }
}
strong{
    color:white;
}
.car {
    width: 1200px; 
    height: 500px;
    object-fit: cover;
    display: block;
    margin: 0 auto; 
}

.new-arrival {
    text-align: center; 
}

.container {
    max-width: 1200px; 
    margin: 0 auto; 
}

.category-banner {
    display: flex;
    justify-content: center;
    align-items: center; 

}

.category-poster {
    max-width: 1200px; 
    height: auto; 
    border-radius: 1200px
    filter: brightness(20%);
}
p{
    color:red;
}
</style>
<?php
include('connection.php');
include('header.php');

?>

<div class="new-arrival">
    <div class="container">
        <div class="category-banner">
            <img src="img/bann.jpg" alt="Category Poster" class="category-poster car" >
        </div>
    </div>
</div>

<?php
$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;

if ($movie_id > 0) {
    $query = "SELECT * FROM movies WHERE movie_id = $movie_id";
    $result = mysqli_query($con, $query);
    $movie = mysqli_fetch_assoc($result);

    if (!$movie) {
        echo "<script>alert('Movie not found!'); window.location.href='view_movies.php';</script>";
        exit;
    }

    echo "<div class='movie-details'>";
    echo "<h2 class='movie-title'>" . $movie['title'] . "</h2>";
    echo "<p class='movie-description'>" . $movie['description'] . "</p>";
    echo "<p><strong>Genre:</strong> " . $movie['genre'] . "</p>";
    echo "<p><strong>Duration:</strong> " . $movie['duration'] . " minutes</p>";
    echo "<p><strong>Rating:</strong> " . $movie['rating'] . "/10</p>";
    echo "</div>"; 

    $query = "SELECT reviews.*, users.username FROM reviews 
              INNER JOIN users ON reviews.user_id = users.user_id 
              WHERE reviews.movie_id = $movie_id ";
    $result = mysqli_query($con, $query);

    echo "<div class='reviews-section'>";
    if (mysqli_num_rows($result) > 0) {
        while ($review = mysqli_fetch_assoc($result)) {
            echo "<div class='review'>";
            echo "<h4 class='review-author'>" . $review['username'] . " - Rating: " . $review['rating'] . "/10</h4>";
            echo "<p class='review-comment'>" . $review['comment'] . "</p>";
            echo "</div><br>";
        }
    } else {
        echo "<p>No reviews for this movie yet.</p>";
    }
    echo "</div>";
}
$con->close();
include('footer.php');
?>
