<?php
include ('connection.php');
include('header.php');
?>
<body>
<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark">
              <h4 class="card-title">Add Cinema</h4>
              <form action="add_cinema.php" method="POST" enctype="multipart/form-data">
                 <label for="name">Cinema Name:</label><br>
                 <input type="text" id="name" name="name" class="form-control bg-light text-dark" required><br><br>

                 <label for="location">Location:</label><br>
                 <input type="text" id="location" name="location" class="form-control bg-light text-dark" required><br><br>

                 <label for="total_screens">Total Screens:</label><br>
                 <input type="number" id="total_screens" name="total_screens" class="form-control bg-light text-dark" required><br><br>

                 <label for="poster">Cinema Poster:</label><br>
                 <input type="file" id="poster" name="poster" class="form-control bg-light text-dark" accept="image/*" required><br><br>

                 <button type="submit" class="btn btn-primary">Add Cinema</button>
              </form>
            </div>
        </div>
    </div>
</div>
</body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $total_screens = $_POST['total_screens'];

    $poster = $_FILES['poster'];

    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = pathinfo($poster['name'], PATHINFO_EXTENSION);
    $file_size = $poster['size'];
    $max_file_size = 5 * 1024 * 1024; 

    if (in_array(strtolower($file_extension), $allowed_extensions)) {
        if ($file_size <= $max_file_size) {
            $upload_dir = "../img/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_name = time() . '.' . $file_extension;
            $upload_path = $upload_dir . $file_name;

            if (move_uploaded_file($poster['tmp_name'], $upload_path)) {
                $query = "INSERT INTO cinemas (name, location, total_screens, poster_url) 
                          VALUES ('$name', '$location', '$total_screens', '$upload_path')";

                if (mysqli_query($con, $query)) {
                    echo "<script>alert('New cinema added successfully!'); window.location.href='view_cinema.php';</script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Error uploading the file.');</script>";
            }
        } else {
            echo "<script>alert('File size exceeds the maximum limit of 5MB.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.');</script>";
    }
}

$con->close();

include('footer.php');
?>
