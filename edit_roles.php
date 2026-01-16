<?php
include 'connection.php'; 
include 'header.php';

if (isset($_GET['role_id'])) {
    $id = $_GET['role_id']; 
    $query = "SELECT * FROM roles WHERE role_id = $id";
    $result = mysqli_query($con, $query);
    $role = mysqli_fetch_assoc($result);
    
    if (!$role) {
        echo "<script>alert('Role not found'); window.location.href='view_roles.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid ID'); window.location.href='view_roles.php';</script>";
    exit;
}
?>

<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark text-light">
                <h4 class="card-title">Update Role</h4>
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="role_name">Role Name</label>
                        <input type="text" class="form-control bg-light text-dark" id="role_name" name="role_name" value="<?php echo htmlspecialchars($role['name']); ?>" required>
                    </div>

                    <!-- If you decide to add a poster or any other field in the future, you can follow this pattern. -->
                    <!-- Example (optional, you can comment this out if no poster is required): -->
                    <!--
                    <div class="form-group">
                        <label for="poster">Poster Image</label>
                        <input type="file" class="form-control bg-light text-dark" id="poster" name="poster" accept="image/*">
                        <small>Current Poster: <img src="<?php echo htmlspecialchars($role['poster']); ?>" alt="Current Poster" width="100"></small>
                    </div>
                    -->
                    
                    <br>
                    <button type="submit" name="update" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update'])) {
    $role_name = mysqli_real_escape_string($con, $_POST['role_name']);

    $q = "UPDATE roles SET name='$role_name' WHERE role_id=$id";    

    if (mysqli_query($con, $q)) {
        echo "<script>alert('Role updated successfully'); window.location.href='view_roles.php';</script>";
    } else {
        echo "<script>alert('Error updating role: " . mysqli_error($con) . "');</script>";
    }
}
?>

<?php
include 'footer.php';
?>
