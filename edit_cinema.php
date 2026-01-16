<?php
include('connection.php');
include('header.php');

if (isset($_GET['cinema_id'])) {
    $cinema_id = $_GET['cinema_id'];

    $query = "SELECT * FROM cinemas WHERE cinema_id = $cinema_id";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $cinema = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Cinema not found.'); window.location.href='view_cinema.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Cinema ID not specified.'); window.location.href='view_cinema.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $total_screens = $_POST['total_screens'];
    $poster = $_FILES['poster'];

    $poster_url = $cinema['poster_url'];

    if ($poster['name']) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = pathinfo($poster['name'], PATHINFO_EXTENSION);
        $file_size = $poster['size'];
        $max_file_size = 5 * 1024 * 1024; // 5MB

        if (in_array(strtolower($file_extension), $allowed_extensions)) {
            if ($file_size <= $max_file_size) {
                $upload_dir = "../img/";
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $file_name = time() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;

                if (move_uploaded_file($poster['tmp_name'], $upload_path)) {
                    $poster_url = $upload_path;
                } else {
                    echo "<script>alert('Error uploading the file.');</script>";
                    exit();
                }
            } else {
                echo "<script>alert('File size exceeds the maximum limit of 5MB.');</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.');</script>";
            exit();
        }
    }

    $update_query = "UPDATE cinemas SET name = '$name', location = '$location', total_screens = $total_screens, poster_url = '$poster_url' WHERE cinema_id = $cinema_id";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Cinema updated successfully!'); window.location.href='view_cinema.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

?>

<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark text-light">
                <h4 class="card-title">Update Cinema</h4>
                <form action="edit_cinema.php?cinema_id=<?php echo $cinema_id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Cinema Name</label>
                        <input type="text" id="name" name="name" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($cinema['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($cinema['location']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="total_screens">Total Screens</label>
                        <input type="number" id="total_screens" name="total_screens" class="form-control bg-light text-dark" value="<?php echo htmlspecialchars($cinema['total_screens']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="poster">Cinema Poster</label>
                        <input type="file" id="poster" name="poster" class="form-control bg-light text-dark" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Current Poster:</label><br>
                        <img src="<?php echo htmlspecialchars($cinema['poster_url']); ?>" alt="Current Cinema Poster" style="max-width: 200px; height: auto;">
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Update Cinema</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
mysqli_close($con);
include('footer.php');
?>
