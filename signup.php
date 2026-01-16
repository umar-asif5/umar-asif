<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $phone_number = mysqli_real_escape_string($con, $_POST['phone_number']);
    $registration_date = mysqli_real_escape_string($con, $_POST['registration_date']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role_id = 2;

    $query = "INSERT INTO users (username, email, password, phone_number, registration_date, role_id) 
              VALUES ('$username', '$email', '$hashed_password', '$phone_number', '$registration_date', '$role_id')";
    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('User registered successfully!'); window.location.href='signin.php';</script>";
    } else {
        echo "<script>alert('Error registering user: " . mysqli_error($con) . "');</script>";
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
            width:100% ;
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
    <source src="img/back.mp4" type="video/mp4" >
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
                            <h3 class="h4">Sign Up</h3>
                        </div>
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingText" name="username" placeholder="jhondoe" required>
                                <label for="floatingText">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" id="floatingPhone" name="phone_number" placeholder="03345367272" required>
                                <label for="floatingPhone">Phone Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control" id="floatingDate" name="registration_date" placeholder="mm/dd/yyyy" required>
                                <label for="floatingDate">Registration Date</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                    <label class="form-check-label text-light" for="exampleCheck1">I agree to the terms and conditions</label>
                                </div>
                            </div>
                            <a href="#" class="text-primary">Forgot Password?</a>
                            <br>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                        </form>
                        <p class="text-center text-light mb-0">Already have an account? <a href="signin.php" class="text-primary">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

</body>

</html>
