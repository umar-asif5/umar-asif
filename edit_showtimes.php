<?php
include('connection.php');
include('header.php');

if (isset($_GET['showtime_id'])) {
    $showtime_id = (int)$_GET['showtime_id'];
    
    $sql = "SELECT st.showtime_id, st.movie_id, st.screen_id, st.showtime, 
                   m.title AS movie_title, s.screen_number, c.name AS cinema_name 
            FROM showtimes st
            JOIN movies m ON st.movie_id = m.movie_id
            JOIN screens s ON st.screen_id = s.screen_id
            JOIN cinemas c ON s.cinema_id = c.cinema_id
            WHERE st.showtime_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $showtime_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $showtime = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$showtime) {
        echo "Showtime not found!";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $movie_id = (int)$_POST['movie_id'];
        $screen_id = (int)$_POST['screen_id'];
        $showtime_time = $_POST['showtime'];

        $update_sql = "UPDATE showtimes SET movie_id = ?, screen_id = ?, showtime = ? 
                       WHERE showtime_id = ?";
        $stmt = mysqli_prepare($con, $update_sql);
        mysqli_stmt_bind_param($stmt, "iisi", $movie_id, $screen_id, $showtime_time, $showtime_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = 'Showtime updated successfully!';
        } else {
            $message = 'Error updating showtime: ' . mysqli_error($con);
        }
        
        mysqli_stmt_close($stmt);
        echo "<script>alert('$message');window.location.href='view_showtimes.php';</script>";
    }
} else {
    echo "Invalid request.";
    exit;
}
if (isset($_GET['showtime_id'])) {
    $showtime_id = (int)$_GET['showtime_id'];

    $sql = "SELECT * FROM showtimes WHERE showtime_id = $showtime_id";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $showtime = mysqli_fetch_assoc($result);
    } else {
        echo "Showtime not found!";
    }
} else {
    echo "No showtime ID provided!";
}

$movies_sql = "SELECT movie_id, title FROM movies";
$movies_result = mysqli_query($con, $movies_sql);

$cinemas_sql = "SELECT cinema_id, name FROM cinemas";
$cinemas_result = mysqli_query($con, $cinemas_sql);

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Edit Showtime</h4>

                        <form method="POST">
                            <div class="form-group">
                                <label for="movie_id">Movie</label>
                                <select name="movie_id" id="movie_id" class="form-control" required>
                                    <option value="">Select Movie</option>
                                    <?php
                                    while ($movie = mysqli_fetch_assoc($movies_result)) {
                                        $selected = $movie['movie_id'] == $showtime['movie_id'] ? 'selected' : '';
                                        echo "<option value='{$movie['movie_id']}' $selected>{$movie['title']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="screen_id">Screen</label>
                                <select name="screen_id" id="screen_id" class="form-control" required>
                                    <option value="">Select Screen</option>
                                    <?php
                                    while ($cinema = mysqli_fetch_assoc($cinemas_result)) {
                                        $screens_sql = "SELECT screen_id, screen_number FROM screens WHERE cinema_id = {$cinema['cinema_id']}";
                                        $screens_result = mysqli_query($con, $screens_sql);
                                        while ($screen = mysqli_fetch_assoc($screens_result)) {
                                            $selected = $screen['screen_id'] == $showtime['screen_id'] ? 'selected' : '';
                                            echo "<option value='{$screen['screen_id']}' $selected>Screen {$screen['screen_number']} (Cinema: {$cinema['name']})</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="showtime">Showtime</label>
                                <input type="datetime" name="showtime" id="showtime" class="form-control" value="<?php echo $showtime['showtime']; ?>" required>
                            </div>

                            <button type="submit" class="btn btn-success">Update Showtime</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
