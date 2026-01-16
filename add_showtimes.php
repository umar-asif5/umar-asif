<?php
include('connection.php');
include('header.php');

$movies_sql = "SELECT movie_id, title FROM movies";
$movies_result = mysqli_query($con, $movies_sql);

$cinemas_sql = "SELECT cinema_id, name FROM cinemas";
$cinemas_result = mysqli_query($con, $cinemas_sql);

if (isset($_POST['action']) && $_POST['action'] == 'add') {
    if (isset($_POST['movie_id'], $_POST['screen_id'], $_POST['showtime'])) {
        $movie_id = (int)$_POST['movie_id'];
        $screen_id = (int)$_POST['screen_id'];
        $showtime = $_POST['showtime'];

        $insert_sql = "INSERT INTO showtimes (movie_id, screen_id, showtime) 
                       VALUES (?, ?, ?)";
        
        $stmt = mysqli_prepare($con, $insert_sql);
        
        mysqli_stmt_bind_param($stmt, "iis", $movie_id, $screen_id, $showtime);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = 'New showtime added successfully!';
        } else {
            $message = 'Error adding showtime: ' . mysqli_error($con);
        }
        
        mysqli_stmt_close($stmt);

        echo "<script>alert('$message');</script>";
    } else {
        $message = 'Please fill in all required fields!';
        echo "<script>alert('$message');</script>";
    }
}

?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Add New Showtime</h4>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="movie_id">Movie</label>
                                <select name="movie_id" id="movie_id" class="form-control" required>
                                    <option value="">Select Movie</option>
                                    <?php
                                    while ($movie = mysqli_fetch_assoc($movies_result)) {
                                        echo "<option value='" . $movie['movie_id'] . "'>" . $movie['title'] . "</option>";
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
                                            echo "<option value='" . $screen['screen_id'] . "'>Screen " . $screen['screen_number'] . " (Cinema: " . $cinema['name'] . ")</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="showtime">Showtime</label>
                                <input type="datetime-local" name="showtime" id="showtime" class="form-control bg-light text-dark" required placeholder="HH:MM AM/PM">
                            </div><br>

                            <button type="submit" name="action" value="add" class="btn btn-success">Add New Showtime</button>
                        </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
