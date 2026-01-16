<?php
include('connection.php');
include('header.php');

$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;

if ($movie_id > 0) {
    $query = "SELECT * FROM movies WHERE movie_id = $movie_id";
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
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $duration = (int)$_POST['duration'];
    $release_date = mysqli_real_escape_string($con, $_POST['release_date']);
    $rating = (float)$_POST['rating'];
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $category_id = (int)$_POST['category_id'];

    // Handle poster image upload
    $poster_url = $movie['poster_url'];
    if (isset($_FILES['poster_url']) && $_FILES['poster_url']['error'] == 0) {
        $file_name = $_FILES['poster_url']['name'];
        $file_tmp = $_FILES['poster_url']['tmp_name'];
        $upload_dir = 'uploads/posters/';
        $poster_url = $upload_dir . basename($file_name);

        if (move_uploaded_file($file_tmp, $poster_url)) {
            // Successfully uploaded poster
        } else {
            echo "<script>alert('Error uploading poster image!');</script>";
        }
    }

    // Handle trailer video upload
    $trailer_url = $movie['trailer_url'];
    if (isset($_FILES['trailer_url']) && $_FILES['trailer_url']['error'] == 0) {
        $trailer_name = $_FILES['trailer_url']['name'];
        $trailer_tmp = $_FILES['trailer_url']['tmp_name'];
        $trailer_dir = 'uploads/trailers/';
        $trailer_url = $trailer_dir . basename($trailer_name);

        if (move_uploaded_file($trailer_tmp, $trailer_url)) {
            // Successfully uploaded trailer
        } else {
            echo "<script>alert('Error uploading trailer video!');</script>";
        }
    }

    // Update movie record
    $query = "UPDATE movies SET title = '$title', description = '$description', duration = $duration, 
              release_date = '$release_date', rating = $rating, genre = '$genre', poster_url = '$poster_url', 
              trailer_url = '$trailer_url', category_id = $category_id WHERE movie_id = $movie_id";

    if (mysqli_query($con, $query)) {
        echo "<script>alert('Movie updated successfully!'); window.location.href='view_movies.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>

<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark text-light">
                <h4 class="card-title">Update Movie</h4>
                <form action="edit_movies.php?movie_id=<?php echo $movie_id; ?>" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="title">Movie Title</label>
                        <input type="text" id="title" name="title" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control bg-light text-dark" rows="4" required><?php echo htmlspecialchars($movie['description']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="duration">Duration (in minutes)</label>
                        <input type="number" id="duration" name="duration" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($movie['duration']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date" id="release_date" name="release_date" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($movie['release_date']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <input type="number" id="rating" name="rating" class="form-control bg-light text-dark" step="0.1" min="0" max="10" value="<?php echo htmlspecialchars($movie['rating']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" id="genre" name="genre" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($movie['genre']); ?>" required>
                    </div>

                    <!-- Category dropdown -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" class="form-control bg-light text-dark" required>
                            <option value="">Select Category</option>
                            <?php
                            // Fetch categories from the 'category' table
                            $categories = mysqli_query($con, "SELECT category_id, name FROM category");
                            while ($category = mysqli_fetch_assoc($categories)) {
                                $selected = ($movie['category_id'] == $category['category_id']) ? 'selected' : '';
                                echo "<option value='" . $category['category_id'] . "' $selected>" . htmlspecialchars($category['name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Poster upload -->
                    <div class="form-group">
                        <label for="poster_url">Poster</label><br>
                        <input type="file" id="poster_url" name="poster_url" class="form-control-file bg-light" style="display: none;" onchange="updateFileName()">
                        <label for="poster_url" class="btn btn-danger" id="fileLabel"><?php echo basename($movie['poster_url']) ? basename($movie['poster_url']) : 'Choose File'; ?></label>
                    </div>
                    <br>
                    <!-- Trailer upload -->
                    <div class="form-group">
                        <label for="trailer_url">Trailer</label><br>
                        <input type="file" id="trailer_url" name="trailer_url" class="form-control-file bg-light" style="display: none;" onchange="updateTrailerFileName()">
                        <label for="trailer_url" class="btn btn-primary" id="trailerFileLabel"><?php echo basename($movie['trailer_url']) ? basename($movie['trailer_url']) : 'Choose Trailer'; ?></label>
                    </div>

                    <script>
                        function updateFileName() {
                            const fileInput = document.getElementById('poster_url');
                            const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'Choose File';
                            document.getElementById('fileLabel').textContent = fileName;
                        }

                        function updateTrailerFileName() {
                            const fileInput = document.getElementById('trailer_url');
                            const fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'Choose Trailer';
                            document.getElementById('trailerFileLabel').textContent = fileName;
                        }
                    </script>
                     <br>
                    <button type="submit" class="btn btn-primary">Update Movie</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$con->close();
include('footer.php');
?>
