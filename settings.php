<?php
include('connection.php');
include('header.php');

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $registration_date = mysqli_real_escape_string($con, $_POST['registration_date']);

    $password = '';
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $user['password'];
    }

    $update_query = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password', phone_number = '$phone_number', registration_date = '$registration_date' WHERE user_id = '$user_id'";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($con) . "');</script>";
    }
}
?>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx--12 shadow">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.php" class="text-decoration-none">
                            <h3 class="h4"> Settings</h3>
                            <br>
                                <h3 class="text-primary"><img src="img/logo.png" alt="" height="65px"></h3>
                            </a>
                     
                        </div>
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingText" name="username" value="<?php echo $user['username']; ?>" required>
                                <label for="floatingText">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" value="<?php echo $user['email']; ?>" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Leave empty to keep the current password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingPhone" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
                                <label for="floatingPhone">Phone Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingDate" name="registration_date" value="<?php echo $user['registration_date']; ?>" required>
                                <label for="floatingDate">Registration Date</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                    <label class="form-check-label text-light" for="exampleCheck1">I agree to the terms and conditions</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    include('footer.php');
    ?>