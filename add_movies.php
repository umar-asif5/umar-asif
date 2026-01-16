<?php
include('connection.php');
include('header.php');

function handleFileUpload($inputName, $targetDir, $allowedTypes) {
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = basename($_FILES[$inputName]['name']);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('Only " . implode(", ", $allowedTypes) . " files are allowed.');</script>";
            return false;
        }

        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {
            echo "<script>alert('Error uploading the " . $inputName . " file.');</script>";
            return false;
        }
    }
    return false;
}

?>

<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark">
                <h4 class="card-title">Add Movies</h4>
                <form action="add_movies.php" method="POST" enctype="multipart/form-data">
                    <label for="title">Movie Title:</label><br>
                    <input type="text" id="title" name="title" class="form-control bg-light text-dark" required><br><br>

                    <label for="category_id">Category:</label><br>
                    <select id="category_id" name="category_id" class="form-control bg-light text-dark" required>
                    <option value="">Select Category</option>
                    <?php
                    $result = mysqli_query($con, "SELECT category_id, name FROM category");

                    if ($result) {
                     while ($row = mysqli_fetch_assoc($result)) {
                         echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                    }
                    } else {
                    echo "<option value=''>No Categories Available</option>";
                    }
                    ?>
                    </select><br><br>


                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" class="form-control bg-light text-dark" rows="4" required></textarea><br><br>

                    <label for="duration">Duration (in minutes):</label><br>
                    <input type="number" id="duration" name="duration" class="form-control bg-light text-dark" required><br><br>

                    <label for="release_date">Release Date:</label><br>
                    <input type="date" id="release_date" name="release_date" class="form-control bg-light text-dark" required><br><br>

                    <label for="rating">Rating:</label><br>
                    <input type="number" id="rating" name="rating" class="form-control bg-light text-dark" step="0.1" min="0" max="10" required><br><br>

                    <label for="genre">Genre:</label><br>
                    <input type="text" id="genre" name="genre" class="form-control bg-light text-dark" required><br><br>

                    <label for="poster_url">Poster:</label><br>
                    <input type="file" id="poster_url" name="poster_url" class="form-control-file bg-light" required onchange="updateFileName()" style="display: none;">
                    <label for="poster_url" class="btn btn-primary" id="fileLabel">Choose File</label><br><br>

                    <label for="trailer_url">Trailer:</label><br>
                    <input type="file" id="trailer_url" name="trailer_url" class="form-control-file bg-light" required onchange="updateTrailerFileName()" style="display: none;">
                    <label for="trailer_url" class="btn btn-primary" id="trailerFileLabel">Choose Trailer</label><br><br>

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
                    <button type="submit" class="btn btn-success">Add Movie</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $duration = (int)$_POST['duration'];
    $release_date = mysqli_real_escape_string($con, $_POST['release_date']);
    $rating = (float)$_POST['rating'];
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $category_id = (int)$_POST['category_id']; // Get the selected category_id from the form

    // Validation checks
    if ($rating < 0 || $rating > 10) {
        echo "<script>alert('Rating must be between 0 and 10.');</script>";
    } elseif ($duration <= 0) {
        echo "<script>alert('Duration must be a positive number.');</script>";
    } elseif ($category_id <= 0) {
        echo "<script>alert('Please select a valid category.');</script>";
    } else {
        $poster_url = handleFileUpload('poster_url', 'img/', ['jpg', 'jpeg', 'png', 'gif']);
        $trailer_url = handleFileUpload('trailer_url', 'trailers/', ['mp4', 'avi', 'mov', 'mkv']);

        if ($poster_url && $trailer_url) {
            $stmt = $con->prepare("INSERT INTO movies (title, description, duration, release_date, rating, genre, poster_url, trailer_url, category_id) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssisissii', $title, $description, $duration, $release_date, $rating, $genre, $poster_url, $trailer_url, $category_id);

            if ($stmt->execute()) {
                echo "<script>alert('New movie added successfully!'); window.location.href='view_movies.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        }
    }
}

$con->close();
include('footer.php');
?>
