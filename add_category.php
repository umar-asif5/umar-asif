<?php
include ('connection.php'); 
include ('header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);
    
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $file_name = $_FILES['poster']['name'];
        $file_tmp = $_FILES['poster']['tmp_name'];
        $file_size = $_FILES['poster']['size'];
        
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        $allowed_types = ['jpeg', 'jpg', 'png', 'gif'];
        $max_file_size = 2 * 1024 * 1024; 

        if (in_array($file_extension, $allowed_types) && $file_size <= $max_file_size) {
            $image_info = getimagesize($file_tmp);
            if ($image_info === false) {
                echo "<script>alert('Uploaded file is not a valid image.');</script>";
            } else {
                $upload_dir = 'img/';
                
                $unique_file_name = uniqid('poster_', true) . '.' . $file_extension;
                $target_file = $upload_dir . $unique_file_name;
                
                if (move_uploaded_file($file_tmp, $target_file)) {
                    $query = "INSERT INTO category (name, poster_url) VALUES ('$category_name', '$target_file')";
                    
                    if (mysqli_query($con, $query)) {
                        echo "<script>alert('Category added successfully!'); window.location.href='view_category.php';</script>";
                    } else {
                        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
            }
        } else {
            echo "<script>alert('Invalid file type or file size exceeds the limit.');</script>";
        }
    } else {
        echo "<script>alert('Please select a valid image file.');</script>";
    }
}
?>
<body>
<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark">
                <h4 class="card-title">Add Category</h4>
                <form method="POST" action="add_category.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control text-dark bg-light" name="category_name" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="poster">Poster Image</label>
                        <input type="file" class="form-control text-dark bg-light" name="poster" accept="image/*" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
include 'footer.php';
?>
