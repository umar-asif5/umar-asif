<?php
include('header.php'); 
include('connection.php'); 
$sql = "
SELECT 
    c.cinema_id, 
    c.name AS cinema_name, 
    c.location, 
    c.total_screens, 
    c.poster_url AS cinema_poster, 
    m.movie_id, 
    m.title AS movie_title 
FROM 
    cinemas c
LEFT JOIN 
    showtimes st ON c.cinema_id = st.screen_id  -- Join on screen_id
LEFT JOIN 
    movies m ON st.movie_id = m.movie_id       -- Join on movie_id to get movie details
ORDER BY 
    c.name, m.title;
";


$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

$cinemas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cinema_id = $row['cinema_id'];

    if (!isset($cinemas[$cinema_id])) {
        $cinemas[$cinema_id] = [
            'cinema_name' => $row['cinema_name'],
            'location' => $row['location'],
            'total_screens' => $row['total_screens'],
            'cinema_poster' => $row['cinema_poster'],
            'movies' => []
        ];
    }

    if (!empty($row['movie_id'])) {
        $cinemas[$cinema_id]['movies'][] = [
            'movie_id' => $row['movie_id'],
            'movie_title' => $row['movie_title']
        ];
    }
}
?>

<div class="new-arrival">
    <div class="container">
        <div class="category-banner">
            <img src="img/ban.jpg" alt="Category Poster" class="category-poster">
        </div>

        <!-- Section Title -->
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <div class="section-title mb-60 text-center">
                    <h2>Cinemas and Movies</h2>
                </div>
            </div>
        </div>

        <!-- Cinema Listings -->
        <div class="row">
            <?php foreach ($cinemas as $cinema) { ?>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="single-new-arrival mb-4">
                        <!-- Cinema Poster -->
                        <div class="popular-img">
                            <img src="../admin/<?php echo $cinema['cinema_poster']; ?>" alt="Cinema Poster" class="movie-poster">
                        </div>

                        <!-- Cinema Details -->
                        <div class="popular-caption">
                            <h3><?php echo htmlspecialchars($cinema['cinema_name']); ?></h3>
                            <p>Location: <?php echo htmlspecialchars($cinema['location']); ?></p>
                            <p>Total Screens: <?php echo htmlspecialchars($cinema['total_screens']); ?></p>
                        </div>

                        <!-- Movies in the Cinema -->
                        <div class="movies-list">
                            <h4>Available Movies:</h4>
                            <?php if (!empty($cinema['movies'])) { ?>
                                <ul>
                                    <?php foreach ($cinema['movies'] as $movie) { ?>
                                        <li>
                                            <a href="description.php?movie_id=<?php echo $movie['movie_id']; ?>"><?php echo htmlspecialchars($movie['movie_title']); ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <p>No movies available for this cinema.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<style>
/* Basic Styling */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #000;
    color: #fff;
}

.category-banner {
    width: 100%;
    filter: brightness(20%);
}

.category-poster {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.movie-poster {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 5px;
}

.single-new-arrival {
    background-color: #333;
    padding: 15px;
    border: 1px solid #444;
    border-radius: 5px;
    margin-bottom: 30px;
}

.single-new-arrival h3 {
    color: #fff;
    font-size: 20px;
    margin-top: 10px;
}

.movies-list h4 {
    margin-top: 20px;
    font-size: 18px;
}

.movies-list ul {
    padding-left: 20px;
    list-style: disc;
}

.movies-list ul li {
    color: #ccc;
    margin-bottom: 5px;
}

.movies-list ul li a {
    color: #ff0000;
    text-decoration: none;
}

.movies-list ul li a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .movies-list ul li {
        font-size: 14px;
    }
}
</style>

<?php
include('footer.php'); // Include the footer
?>
