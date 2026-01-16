<?php
include('connection.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page or show an error
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the current user details
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);

// Validate the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $registration_date = mysqli_real_escape_string($con, $_POST['registration_date']);
    $password = $user['password']; // Default password (no change)

    // Only hash the password if the user provided a new one
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashed_password = $password;
    }

    // Update query
    $update_query = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password', phone_number = '$phone_number', registration_date = '$registration_date' WHERE user_id = '$user_id'";

    // Execute the query and show success or error message
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($con) . "');</script>";
    }
}
?>

<body>
    <div class="container-fluid position-relative d-flex p-0" style="background-color: #000;"> <!-- Set background color here -->
        <div class="container-fluid">
            <div class="row h-10 align-items-center justify-content-center" style="min-height: 50vh;"> <!-- Adjust height here -->
                <div class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-3"> <!-- Smaller column size -->
                    <div class="bg-dark rounded p-3 p-sm-4 my-4 mx-0 shadow"> <!-- Adjusted padding and margin for a smaller form -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.php" class="text-decoration-none">
                                <h3 class="h4 text-white">Settings</h3>
                                <br>
                                <h3 class="text-primary"><img src="img/logo.png" alt="" height="50px"> <!-- Smaller logo -->
                                </h3>
                            </a>
                        </div>
                        <form action="" method="POST">
                            <!-- Username -->
                            <div class="form-floating mb-2"> <!-- Reduced margin-bottom -->
                                <input type="text" class="form-control" id="floatingText" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                <label for="floatingText">Username</label>
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-2"> <!-- Reduced margin-bottom -->
                                <input type="email" class="form-control" id="floatingInput" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <label for="floatingInput">Email address</label>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-2"> <!-- Reduced margin-bottom -->
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Leave empty to keep the current password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <!-- Phone Number -->
                            <div class="form-floating mb-2"> <!-- Reduced margin-bottom -->
                                <input type="number" class="form-control" id="floatingPhone" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
                                <label for="floatingPhone">Phone Number</label>
                            </div>

                            <!-- Registration Date -->
                            <div class="form-floating mb-2"> <!-- Reduced margin-bottom -->
                                <input type="date" class="form-control" id="floatingDate" name="registration_date" value="<?php echo htmlspecialchars($user['registration_date']); ?>" required>
                                <label for="floatingDate">Registration Date</label>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="d-flex align-items-center justify-content-between mb-3"> <!-- Reduced margin-bottom -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                    <label class="form-check-label text-light" for="exampleCheck1">I agree to the terms and conditions</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-danger py-2 w-100 mb-3">Update</button> <!-- Reduced padding and margin-bottom -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
