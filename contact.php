<?php
include('header.php');
include('connection.php');

// Define variables and initialize with empty values
$name = $email = $phone = $message = "";
$name_err = $email_err = $phone_err = $message_err = "";

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // Validate message
    if (empty(trim($_POST["message"]))) {
        $message_err = "Please write a message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // If there are no errors, insert data into the database
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($message_err)) {
        // Prepare an insert query
        $sql = "INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $message);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // If successful, redirect or show a success message
                echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
            } else {
                echo "Something went wrong. Please try again.";
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($con);
}

?>

<style>
      .banner {
        background-image: url('img/contact.jpg');
        background-size: cover;
        height: 400px;
        margin-bottom: 20px;
        filter: brightness(20%);
    }
</style>

<div class="banner"></div>

<section id="contact" class="p_3">
    <div class="container-xl">
        <div class="row contact_1 m-0 mb-5">
            <div class="col-md-4">
                <div class="contact_1i row">
                    <div class="col-md-2">
                        <div class="contact_1il">
                            <span class="col_red fs-1"><i class="fa fa-building"></i></span>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="contact_1ir">
                            <h5>Tab&Tech Shop No 276 2nd Floor Starcity Mall Saddar Karachi,Pakistan</h5>
                            <h6 class="mb-0">Find Us</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact_1i row">
                    <div class="col-md-2">
                        <div class="contact_1il">
                            <span class="col_red fs-1"><i class="fa fa-phone"></i></span>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="contact_1ir">
                            <h5>+92 3010212703</h5>
                            <h6 class="mb-0">Make a call</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact_1i row">
                    <div class="col-md-2">
                        <div class="contact_1il">
                            <span class="col_red fs-1"><i class="fa fa-envelope-o"></i></span>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="contact_1ir">
                            <h5>filmflex15@gmail.com</h5>
                            <h6 class="mb-0">Drop us a line</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row contact_2">
            <div class="col-md-6">
                <div class="contact_2l">
                    <form method="POST" action="">
                        <div class="blog_1d3i row">
                            <div class="col-md-6">
                                <div class="blog_1d3il">
                                    <input placeholder="Name" class="form-control" type="text" name="name" value="<?php echo $name; ?>">
                                    <div class="error-container">
                                        <span class="error"><?php echo $name_err; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="blog_1d3il">
                                    <input placeholder="Enter Email" class="form-control" type="email" name="email" value="<?php echo $email; ?>">
                                    <div class="error-container">
                                        <span class="error"><?php echo $email_err; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog_1d3i row">
                            <div class="col-md-12">
                                <div class="blog_1d3il">
                                    <input placeholder="Your Phone" class="form-control mt-4" type="text" name="phone" value="<?php echo $phone; ?>">
                                    <div class="error-container">
                                        <span class="error"><?php echo $phone_err; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog_1d3i row">
                            <div class="col-md-12">
                                <div class="blog_1d3il">
                                    <textarea placeholder="Write a Message" class="form-control form_text mt-4" name="message"><?php echo $message; ?></textarea>
                                    <div class="error-container">
                                        <span class="error"><?php echo $message_err; ?></span>
                                    </div>
                                    <h5 class="mt-4">
                                        <button type="submit" class="button_1">Send Message</button>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact_2r">
                    <iframe src="https://www.google.com/maps/embed?pb=..." height="420" style="border:0; width:100%;" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include ('footer.php');
?>
