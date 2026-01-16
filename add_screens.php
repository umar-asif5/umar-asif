<?php
include('connection.php');
include('header.php');

$sql = "SELECT s.screen_id, s.cinema_id, s.screen_number, s.capacity, c.name AS cinema_name
        FROM screens s
        JOIN cinemas c ON s.cinema_id = c.cinema_id";
$result = mysqli_query($con, $sql);

if (isset($_POST['action'])) {
    if (isset($_POST['screen_id'])) {
        $screen_id = (int)$_POST['screen_id'];
    } else {
        $screen_id = null;
    }

    switch ($_POST['action']) {
        case 'delete':
            if ($screen_id !== null) {
                $delete_sql = "DELETE FROM screens WHERE screen_id = $screen_id";
                if (mysqli_query($con, $delete_sql)) {
                    $message = 'Screen deleted successfully!';
                } else {
                    $message = 'Error deleting screen: ' . mysqli_error($con);
                }
            }
            break;

        case 'update':
            if ($screen_id !== null && isset($_POST['screen_number'], $_POST['capacity'], $_POST['cinema_id'])) {
                $screen_number = (int)$_POST['screen_number'];
                $capacity = (int)$_POST['capacity'];
                $cinema_id = (int)$_POST['cinema_id'];

                $update_sql = "UPDATE screens 
                               SET screen_number = $screen_number, capacity = $capacity, cinema_id = $cinema_id 
                               WHERE screen_id = $screen_id";
                if (mysqli_query($con, $update_sql)) {
                    $message = 'Screen updated successfully!';
                } else {
                    $message = 'Error updating screen: ' . mysqli_error($con);
                }
            } else {
                $message = 'Please fill all fields to update the screen!';
            }
            break;

        case 'add':
            if (isset($_POST['screen_number'], $_POST['capacity'], $_POST['cinema_id'])) {
                $screen_number = (int)$_POST['screen_number'];
                $capacity = (int)$_POST['capacity'];
                $cinema_id = (int)$_POST['cinema_id'];

                $insert_sql = "INSERT INTO screens (cinema_id, screen_number, capacity) 
                               VALUES ($cinema_id, $screen_number, $capacity)";
                if (mysqli_query($con, $insert_sql)) {
                    $message = 'New screen added successfully!';
                } else {
                    $message = 'Error adding screen: ' . mysqli_error($con);
                }
            }
            break;

        default:
            $message = 'Invalid action!';
            break;
    }
    echo "<script>alert('$message');</script>";
}

$cinemas_sql = "SELECT cinema_id, name FROM cinemas";
$cinemas_result = mysqli_query($con, $cinemas_sql);

if (isset($_GET['screen_id'])) {
    $screen_id = (int)$_GET['screen_id'];
    $edit_sql = "SELECT * FROM screens WHERE screen_id = $screen_id";
    $edit_result = mysqli_query($con, $edit_sql);
    $edit_data = mysqli_fetch_assoc($edit_result);

    if (!$edit_data) {
        die('Screen not found!');
    }
} else {
    $edit_data = null;
}

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Manage Screens</h4>

                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="cinema_id">Cinema</label>
                                <select name="cinema_id" id="cinema_id" class="form-control" required>
                                    <option value="">Select Cinema</option>
                                    <?php
                                    while ($cinema = mysqli_fetch_assoc($cinemas_result)) {
                                        $selected = ($edit_data && $edit_data['cinema_id'] == $cinema['cinema_id']) ? 'selected' : '';
                                        echo "<option value='" . $cinema['cinema_id'] . "' $selected>" . $cinema['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="screen_number">Screen Number</label>
                                <input type="number" name="screen_number" id="screen_number" class="form-control bg-light text-dark" required value="<?php echo $edit_data['screen_number'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input type="number" name="capacity" id="capacity" class="form-control bg-light text-dark" required value="<?php echo $edit_data['capacity'] ?? ''; ?>">
                            </div><br>
                            <button type="submit" name="action" value="<?php echo $edit_data ? 'update' : 'add'; ?>" class="btn btn-success"><?php echo $edit_data ? 'Update Screen' : 'Add New Screen'; ?></button>
                        </form>
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
