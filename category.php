<?php
include('header.php');
include('connection.php');

// Check if the category_id is set and valid
if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $cat_id = (int) $_GET['category_id'];

    // Prepare the query to fetch category data using prepared statements
    $cat_sql = "SELECT name, poster FROM category WHERE category_id = ?";
    if ($stmt = mysqli_prepare($con, $cat_sql)) {
        // Bind the category_id parameter
        mysqli_stmt_bind_param($stmt, "i", $cat_id);
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
        // Get the result
        $cat_r = mysqli_stmt_get_result($stmt);
        
        // Fetch the category data
        $cat_data = mysqli_fetch_assoc($cat_r);
        
        // If category is not found, show an error message
        if (!$cat_data) {
            echo "<p>Category not found.</p>";
            exit;
        }

        // Close the category query statement
        mysqli_stmt_close($stmt);

    } else {
        // If query preparation fails
        echo "Error in preparing category query.";
        exit;
    }

    // Now fetch movies belonging to the category
    $movie_sql = "SELECT m.movie_id, m.title, m.duration, m.release_date, m.description, m.genre, m.poster_url, m.trailer_url, c.name AS category_name
                  FROM movies AS m
                  JOIN category AS c ON m.category_id = c.category_id 
                  WHERE c.category_id = ?";
    
    if ($stmt = mysqli_prepare($con, $movie_sql)) {
        // Bind the category_id to the query
        mysqli_stmt_bind_param($stmt, "i", $cat_id);
        // Execute the statement
        mysqli_stmt_execute($stmt);
        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Check if any movies are returned
        if (mysqli_num_rows($result) == 0) {
            echo "<p>No movies found in this category.</p>";
        }

        // Close the movie query statement
        mysqli_stmt_close($stmt);

    } else {
        // If movie query preparation fails
        echo "Error in preparing movie query.";
    }

} else {
    echo "Invalid or missing category_id.";
}
?>

<div class="new-arrival">
    <div class="container">
        <div class="category-banner">
            <!-- Ensure $cat_data is valid before displaying the category poster -->
            <?php if ($cat_data): ?>
                <img src="../admin/<?php echo htmlspecialchars($cat_data['poster']); ?>" alt="Category Poster" class="category-poster">
            <?php else: ?>
                <p>No category data available.</p>
            <?php endif; ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <div class="section-title mb-60 text-center wow fadeInUp" data-wow-duration="2s" data-wow-delay=".2s">
                    <!-- Ensure $cat_data is valid before displaying the category name -->
                    <?php if ($cat_data): ?>
                        <h2><?php echo htmlspecialchars($cat_data['name']); ?></h2>
                    <?php else: ?>
                        <p>No category data available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <?php 
            // Fetch and display movies from the $result
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="single-new-arrival mb-4 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                        <div class="popular-img position-relative">
                            <!-- Movie poster -->
                            <img src="../admin/<?php echo htmlspecialchars($row['poster_url']); ?>" alt="Movie Poster" class="movie-poster" style="height:250px;">
                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <!-- Heart Icon: Will trigger addToFavorites when clicked -->
                                <i class="favorite-heart fas fa-heart position-absolute top-0 end-0 m-2" 
                                   data-movie-id="<?php echo $row['movie_id']; ?>" 
                                   onclick="addToFavorites(<?php echo $row['movie_id']; ?>)">
                                </i>
                            <?php } ?>
                        </div>

                        <div class="popular-caption">
                            <h3><a href="description.php?movie_id=<?php echo $row['movie_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h3>
                            <p class="movie-description"><?php echo htmlspecialchars($row['description']); ?></p>
                            <a href="description.php?movie_id=<?php echo $row['movie_id']; ?>" class="btn btn-primary">View More</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
}

.new-arrival {
    background-color: #000; 
    padding-top: 0; 
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
    height: auto;
    object-fit: cover;
    border-radius: 5px;
}

.movie-description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 15px;
    font-size: 14px;
    color: #fff; 
}

.favorite-heart {
    font-size: 24px;
    color: #fff;
    cursor: pointer;
    transition: color 0.3s ease;
}

.favorite-heart:hover {
    color: #ff0000; 
}


.btn-primary {
    background-color: #ff0000;
    border-color: #ff0000; 
    padding: 8px 16px;
    font-size: 14px;
    cursor: pointer;
    display: inline-block;
    width: 100%;
    text-align: center;
    color: white; 
    border-radius: 5px;
    margin-top: 10px;
}

.single-new-arrival {
    display: flex;
    flex-direction: column;
    height: auto; 
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    box-sizing: border-box;
    background-color: #333; 
    color: #fff; 
    justify-content: flex-start;
    margin-bottom: 30px; 
}

.single-new-arrival .popular-caption {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.popular-caption h3 {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 15px; 
    color: #fff; 
    overflow-wrap: break-word; 
}

.new-arrival .section-title h2 {
    color: #fff;
    font-weight: 500; 
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    .btn-primary {
        font-size: 12px;
        padding: 6px 12px;
    }

    .movie-description {
        font-size: 12px;
    }
}

.row .col-xl-3, .row .col-lg-3, .row .col-md-6, .row .col-sm-6 {
    margin-bottom: 30px; 
}
</style>
<script>
   function addToFavorites(movieId) {
        // Check if the user is logged in
        if (<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
            var userId = <?php echo $_SESSION['user_id']; ?>;  // Get the user_id from the session
            
            // Make an AJAX request to add the movie to favorites
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_favorites.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            // Send the user_id and movie_id in the POST request
            xhr.send('user_id=' + userId + '&movie_id=' + movieId);
            
            // Handle the response from the server
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);  // Show the server response message
                    var heartIcon = document.querySelector('.favorite-heart[data-movie-id="' + movieId + '"]');
                    if (heartIcon) {
                        heartIcon.style.color = "#ff0000";  // Change the heart to red
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };
        } else {
            alert('You need to be logged in to add to favorites.');
        }
    }

</script>
<?php
include('footer.php');
?>
