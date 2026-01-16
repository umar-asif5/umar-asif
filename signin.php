<?php
// Start session at the beginning of the file
session_start();
include('connection.php');

// Handle login if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check for user in the database
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            // Set session variables for the logged-in user
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the index page
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FilmFlex</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* Full Screen Video Background */
        body, html {
            height: 100%;
            margin: 0;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: brightness(30%);
            padding: 0px;
        }
        .container-fluid {
            position: relative;
            z-index: 1;
        }

        .bg-secondary {
            background-color: #000 !important;
            border-radius: 150px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            opacity: 50%;
            width:100%;
            height: 100%;
        }

        .text-primary {
            color: #d00 !important;
        }

        .btn-primary {
            background-color: #d00 !important;
            border: none;
        }

        .btn-primary:hover {
            background-color: #b00 !important;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #333;
            background-color: #333;
            color: white;
        }

        .form-control:focus {
            border-color: #d00;
            background-color: #222;
            color: white;
        }

        .form-check-label {
            color: white;
        }

        .form-floating label {
            color: #aaa;
        }

        .text-center a {
            color: #d00;
        }

        .text-center a:hover {
            color: #b00;
        }

        .h3 {
            color: #d00;
        }

        .h4 {
            color: #ddd;
        }

        .d-flex a {
            color: #d00;
        }

        .d-flex a:hover {
            color: #b00;
        }
    </style>
</head>

<body>
    <!-- Video Background -->
    <video class="video-background" autoplay muted loop>
        <source src="img/back.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-6">
                <div class="bg-secondary rounded p-4 p-sm-5 my-0 mx-3 shadow">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="text-decoration-none">
                            <h3 class="text-primary"><img src="img/logo.png" alt="" height="50px"></h3>
                        </a>
                        <h3 class="h4">Sign In</h3>
                    </div>
                    <form action="" method="POST">
                        <!-- Username Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingText" name="username" placeholder="jhondoe" required>
                            <label for="floatingText">Username</label>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        
                        <!-- Login Button -->
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                    </form>

                    <!-- Error Message -->
                    <?php if (isset($error_message)): ?>
                        <div class="text-danger text-center"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <!-- Sign Up Link -->
                    <p class="text-center text-light mb-0">Don't have an account? <a href="signup.php" class="text-primary">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
