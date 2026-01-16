<?php
include 'connection.php';
include 'header.php';

if (isset($_GET['category_id'])) {
    $id = (int)$_GET['category_id'];
    $query = "SELECT * FROM category WHERE category_id = $id";  
    $result = mysqli_query($con, $query);
    
    $category = mysqli_fetch_assoc($result);
    
    if (!$category) {
        echo "<script>alert('Category not found'); window.location.href='view_category.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid ID'); window.location.href='view_category.php';</script>";
    exit;
}

?>

<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark text-light">
                <h4 class="card-title">Update Category</h4>
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control bg-light text-dark" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="poster">Poster Image</label>
                        <input type="file" class="form-control bg-light text-dark" id="poster" name="poster" accept="image/*">
                        <small>Current Poster: <img src="<?php echo htmlspecialchars($category['poster']); ?>" alt="Current Poster" width="100"></small>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);
    
    $poster_path = $category['poster'];  // Keep existing poster path unless a new file is uploaded.

    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $file_name = $_FILES['poster']['name'];
        $file_tmp = $_FILES['poster']['tmp_name'];
        $file_size = $_FILES['poster']['size'];
        $file_type = $_FILES['poster']['type'];
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 2 * 1024 * 1024;  

        if (in_array($file_type, $allowed_types) && $file_size <= $max_file_size) {
            $upload_dir = 'img/';
            $target_file = $upload_dir . basename($file_name);

            // Check if file already exists, if so, rename the file to avoid overwriting.
            if (file_exists($target_file)) {
                $file_name = time() . "_" . $file_name; // Prefix with timestamp to make it unique
                $target_file = $upload_dir . $file_name;
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file_tmp, $target_file)) {
                $poster_path = $target_file; // Update poster path to new file path
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type or file size exceeds the limit.');</script>";
        }
    }

    $stmt = mysqli_prepare($con, "UPDATE category SET name=?, poster=? WHERE category_id=?");
    
    mysqli_stmt_bind_param($stmt, "ssi", $category_name, $poster_path, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Category updated successfully'); window.location.href='view_category.php';</script>";
    } else {
        echo "<script>alert('Error updating Category: " . mysqli_error($con) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}

include 'footer.php';
?>
