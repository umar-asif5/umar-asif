<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to be logged in to submit a review.'); window.location.href='signin.php';</script>";
    exit;
} else {
    // Fetch the logged-in user's username
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username']; // Assuming username is stored in session after login
    echo "<script>console.log('User ID: " . $user_id . "');</script>";
}

$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;

if ($movie_id > 0) {
    $query = "SELECT title FROM movies WHERE movie_id = $movie_id";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $movie = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Movie not found!'); window.location.href='view_movies.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid movie ID!'); window.location.href='view_movies.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Ensure rating is between 1 and 10
    if ($rating < 1 || $rating > 10) {
        echo "<script>alert('Please provide a valid rating between 1 and 10.');</script>";
    } else {
        // Insert review into the database, including username
        $query = "INSERT INTO reviews (movie_id, user_id, name, rating, comment)
                  VALUES ('$movie_id', '$user_id', '$username', '$rating', '$comment')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Review submitted successfully!'); window.location.href='view_reviews.php?movie_id=$movie_id';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>
<body>
<h2 class="form-heading center-heading">Submit Review for <?php echo $movie['title']; ?></h2>
<div class="form-container">
    <form action="add_reviews.php?movie_id=<?php echo $movie_id; ?>" method="POST">
        <label for="rating" class="form-label">Rating (1-10):</label><br>
        <input type="number" id="rating" name="rating" class="form-control" min="1" max="10" required><br><br>

        <label for="comment" class="form-label">Comment:</label><br>
        <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea><br><br>

        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
    <button type="button" class="btn btn-secondary" onclick="window.history.back();">Back</button>
</div>


    <video autoplay muted loop class="video-background">
        <source src="img/back.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: brightness(30%);
            padding: 0;
        }
.center-heading {
    text-align: center; 
}

        .form-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 600px;
            margin: 150px auto 0; 
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            opacity: 80%;
        }

        .form-heading {
            color: #d00;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-label {
            color: #ddd;
            font-size: 16px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            margin-bottom: 20px;
            border-radius: 25px;
            border: 1px solid #333;
            background-color: #333;
            color: white;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #d00;
            background-color: #222;
            color: white;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background-color: #d00;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #b00;
        }

        /* Text Links */
        .text-center a {
            color: #d00;
        }

        .text-center a:hover {
            color: #b00;
        }

        .h3, .h4 {
            color: #d00;
        }

        .d-flex a {
            color: #d00;
        }

        .d-flex a:hover {
            color: #b00;
        }

        .btn-secondary {
            width: 100%;
            padding: 12px;
            background-color: #555;  /* You can choose a different color */
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;  /* Adds space between the Submit and Back button */
        }

        .btn-secondary:hover {
            background-color: #444;  /* Hover color */
        }

    </style>
</body>

<?php
$con->close();
?>
