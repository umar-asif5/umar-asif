<?php
include 'connection.php'; 
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Role</title>
    <link rel="stylesheet" href=""> 
</head>
<body>
<div class="main-panel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body bg-dark">
                <h4 class="card-title">Add Roles</h4>
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="Role_name">Role Name</label>
                        <input type="text" class="form-control bg-light text-dark" id="role_name" name="role_name" placeholder="Enter role name" required>
                    </div><br>
                    <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $role_name = $_POST['role_name'];

    if (!empty($role_name)) {
        $query = "INSERT INTO roles (name) VALUES ('$role_name')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>alert('Role added successfully!'); window.location.href='add_roles.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Role name cannot be empty!');</script>";
    }
}
?>

</body>
</html>
<?php
include 'footer.php';
?>
