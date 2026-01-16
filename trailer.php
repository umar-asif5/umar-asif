<?php
include('header.php');
include('connection.php');

if (isset($_GET['movie_id'])) {
    $movie_id = $_GET['movie_id'];
} else {
    echo "<p>No movie ID provided!</p>";
    exit; 
}

$sql = "SELECT trailer_url FROM movies WHERE movie_id = $movie_id";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $movie = mysqli_fetch_assoc($result);
    $trailer_filename = $movie['trailer_url'];

    $trailer_path = "../admin/" . $trailer_filename;
} else {
    echo "<p>Movie not found!</p>";
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Trailer</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: black;
        }

        .trailer-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        video {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>

<div class="trailer-container">
    <video controls autoplay>
        <source src="<?php echo $trailer_path; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
<?php
include('footer.php');
?>
