<?php
include('connection.php');
include('header.php');

if (isset($_GET['screen_id'])) {
    $screen_id = (int)$_GET['screen_id']; 

    $sql = "SELECT * FROM screens WHERE screen_id = $screen_id";
    $result = mysqli_query($con, $sql);
    $screen_data = mysqli_fetch_assoc($result);

    if (!$screen_data) {
        die('Screen not found!');
    }
} else {
    die('No screen ID provided!');
}

$cinemas_sql = "SELECT cinema_id, name FROM cinemas";
$cinemas_result = mysqli_query($con, $cinemas_sql);

if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $cinema_id = (int)$_POST['cinema_id'];
    $screen_number = (int)$_POST['screen_number'];
    $capacity = (int)$_POST['capacity'];

    $update_sql = "UPDATE screens SET cinema_id = $cinema_id, screen_number = $screen_number, capacity = $capacity WHERE screen_id = $screen_id";
    if (mysqli_query($con, $update_sql)) {
        $message = 'Screen updated successfully!';
    } else {
        $message = 'Error updating screen: ' . mysqli_error($con);
    }

    echo "<script>alert('$message');window.location.href='view_screens.php';</script>";
}

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Edit Screen</h4>
                        <form method="POST">
                            <input type="hidden" name="screen_id" value="<?php echo $screen_data['screen_id']; ?>">

                            <div class="form-group">
                                <label for="cinema_id">Cinema</label>
                                <select name="cinema_id" id="cinema_id" class="form-control" required>
                                    <option value="">Select Cinema</option>
                                    <?php
                                    while ($cinema = mysqli_fetch_assoc($cinemas_result)) {
                                        $selected = ($screen_data['cinema_id'] == $cinema['cinema_id']) ? 'selected' : '';
                                        echo "<option value='" . $cinema['cinema_id'] . "' $selected>" . $cinema['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="screen_number">Screen Number</label>
                                <input type="number" name="screen_number" id="screen_number" class="form-control bg-light text-dark" required value="<?php echo $screen_data['screen_number']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input type="number" name="capacity" id="capacity" class="form-control bg-light text-dark" required value="<?php echo $screen_data['capacity']; ?>">
                            </div><br>

                            <button type="submit" name="action" value="update" class="btn btn-success">Update Screen</button>
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
