<?php
session_start();
include('connection.php');

if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];
} else {
    echo "No movie ID provided!";
    exit;
}

$sql = "SELECT * FROM movies WHERE movie_id = $movie_id";
$result = mysqli_query($con, $sql);
$movie = mysqli_fetch_assoc($result);

if (!$movie) {
    echo "<p>Movie not found.</p>";
    exit;
}

$poster_path = "../admin/" . $movie['poster_url'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <style>
        body {
            background-color: #000000; 
            color: #ff0000; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;  
            align-items: center; 
            min-height: 100vh; 
            flex-direction: column; 
        }

        .movie-details {
            display: flex;
            justify-content: center; 
            align-items: flex-start;  
            gap: 20px; 
            flex-wrap: wrap; 
            max-width: 1200px;
            width: 100%;
            padding: 20px;
            margin-top: 120px;
            position: relative; 
        
        }

        .movie-poster {
            flex: 1;
            max-width: 350px;
        }

        .movie-poster img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .movie-info {
            flex: 2;
            max-width: 600px;
        }

        h2 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .movie-trailer {
            margin-top: 20px;
        }

        .movie-trailer button {
            background-color: #ff0000; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2em;
            cursor: pointer;
            text-decoration: none;
        }

        .movie-trailer button:hover {
            background-color: #d00000; 
        }

        /* Cross button styles */
        .close-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            color: #ff0000;
            background: none;
            border: none;
            cursor: pointer;
        }

        .close-button:hover {
            color: #d00000;
        }

        @media (max-width: 768px) {
            .movie-details {
                flex-direction: column; 
                align-items: center;  
            }
            .movie-poster {
                max-width: 100%;
                margin-bottom: 20px;
            }
        }

        .strong {
            color: white;
        }

        .h2 {
            color: white;
        }
        .f1{
            color: white;
        }

        .f2{
            font-size: 60px;
        }
    </style>
</head>
<body>

<!-- Cross button to go back -->
<button class="close-button" onclick="window.history.back();">✖</button>
<h1  class="f2">Book Now</h1>

<div class="movie-details">
    <!-- Movie Poster Section -->
    <div class="movie-poster">
        <img src="<?php echo $poster_path; ?>" alt="Movie Poster">
    </div>

<!-- Movie Information Section -->
<div class="movie-info">
    <h2 class="f1"><?php echo $movie['title']; ?></h2>

    <p><strong class="f1">Description:</strong> <?php echo $movie['description']; ?></p>

    <p><strong class="f1">Duration:</strong> <?php echo $movie['duration']; ?> minutes</p>

    <p><strong class="f1">Release Date:</strong> <?php echo date("F j, Y", strtotime($movie['release_date'])); ?></p>

    <p><strong class="f1">Rating:</strong> <?php echo $movie['rating']; ?>/10</p>

    <p><strong class="f1">Genre:</strong> <?php echo $movie['genre']; ?></p>

    <!-- Movie Trailer Section -->
    <div class="movie-trailer">
        <a href="view_reviews.php?movie_id=<?php echo $movie['movie_id']; ?>">
            <button id="viewReviewBtn" disabled>View Review</button>
        </a>
        <a href="trailer.php?movie_id=<?php echo $movie['movie_id']; ?>" id="watchTrailerBtn">
            <button>Watch Trailer</button>
        </a>
    </div>

    <div class="movie-trailer">
        <!-- Disable the Add Review button initially -->
        <a href="add_reviews.php?movie_id=<?php echo $movie['movie_id']; ?>" id="addReviewBtn" disabled>
            <button>Add Review</button>
        </a>
        <a href="booking.php?movie_id=<?php echo $movie['movie_id']; ?>">
            <button>Add Booking</button>
        </a>
    </div>
</div>

<!-- JavaScript to Enable Review After Watching Trailer -->
<script>
    // Check if the trailer has been watched from localStorage
    let trailerWatched = localStorage.getItem('trailerWatched') === 'true';

    // Get references to the buttons
    const watchTrailerBtn = document.getElementById('watchTrailerBtn');
    const addReviewBtn = document.getElementById('addReviewBtn');
    const viewReviewBtn = document.getElementById('viewReviewBtn');

    // Set the button states based on the trailer watched status
    if (trailerWatched) {
        addReviewBtn.disabled = false;
        viewReviewBtn.disabled = false;
    }

    // Event listener for the "Watch Trailer" button
    watchTrailerBtn.addEventListener('click', function() {
        // Mark trailer as watched and store it in localStorage
        localStorage.setItem('trailerWatched', 'true');

        // Enable the "Add Review" and "View Review" buttons after watching the trailer
        addReviewBtn.disabled = false;
        viewReviewBtn.disabled = false;

        console.log("Trailer watched: ", trailerWatched); // Debugging message
    });

    // Event listener for the "Add Review" button
    addReviewBtn.addEventListener('click', function(event) {
        // Check if the trailer was watched before allowing review
        if (!trailerWatched) {
            event.preventDefault(); // Prevent default action (e.g., form submission or navigation)
            alert("Please watch the trailer first before submitting a review.");
        }
    });
</script>

</div>

</body>
</html>
