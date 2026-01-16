<?php
include('header.php');
include('connection.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to be logged in to submit a review.'); window.location.href='signin.php';</script>";
    exit;  // Stop further execution
} else {
    // Optional: Logging user ID (useful for debugging)
    // echo "<script>console.log('User ID: " . $_SESSION['user_id'] . "');</script>";
}

// Get the movie_id from the GET request
$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;

if ($movie_id > 0) {
    $query = "SELECT title, poster_url FROM movies WHERE movie_id = $movie_id";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $movie = mysqli_fetch_assoc($result);
        $poster_url = "../admin/" . $movie['poster_url'];
    } else {
        // Movie not found, redirect with an error message
        echo "<script>
                alert('Movie not found!');
                window.location.href='category.php';
              </script>";
        exit;
    }
} else {
    // Invalid or missing movie_id, redirect with an error message
    echo "<script>
            alert('Invalid movie ID!');
            window.location.href='category.php';
          </script>";
    exit;
}

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $age = intval($_POST['age']);
    $ticket_type = mysqli_real_escape_string($con, $_POST['ticket_type']);
    $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);

    // Price calculation based on ticket type
    $price = 0;
    switch ($ticket_type) {
        case 'silver':
            $price = 500.00;
            break;
        case 'gold':
            $price = 1000.00; 
            break;
        case 'platinum':
            $price = 1500.00;
            break;
    }

    // Apply discount for children (ages 3-12)
    if ($age >= 3 && $age <= 12) {
        $price *= 0.5;
    }

    // Insert the booking information into the database
    $query = "INSERT INTO entry (first_name, last_name, email, age, ticket_type, price, payment_method) 
              VALUES ('$first_name', '$last_name', '$email', $age, '$ticket_type', $price, '$payment_method')";

    if (mysqli_query($con, $query)) {
        $ticket_id = mysqli_insert_id($con); // Get the last inserted ticket ID

        // Success message
        $booking_success_msg = "Booking successful for $first_name $last_name. Ticket type: $ticket_type, Price: \$$price. 
        <br><a href='view_ticket.php?id=$ticket_id'>Click here to view your ticket</a>";

        // Redirect user to view_ticket.php with the ticket_id after success
        echo "<script>
                alert('Booking successful!');
                window.location.href = 'view_ticket.php?id=$ticket_id';  // Redirect to view_ticket.php with ticket_id
              </script>";
        exit;  // Stop further script execution after redirect
    } else {
        // Error handling
        $booking_error_msg = "Error: " . mysqli_error($con);
        echo "<script>
                alert('$booking_error_msg');
                window.location.href = 'booking.php?movie_id=$movie_id';  // Stay on the booking page if error
              </script>";
        exit;  // Stop further script execution after redirect
    }
}
?>

<style>
    .banner {
        background-image: url('img/bbanner.jpg');
        background-size: cover;
        height: 400px;
        margin-bottom: 20px;
        filter: brightness(20%);
    }

    .confirmation-message {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        margin: 20px;
        border-radius: 5px;
        text-align: center;
    }
</style>

<div class="banner"></div>

<?php if (isset($booking_success_msg)) { ?>
    <div class="confirmation-message">
        <?php echo $booking_success_msg; ?>
    </div>
<?php } elseif (isset($booking_error_msg)) { ?>
    <div class="error-message">
        <?php echo $booking_error_msg; ?>
    </div>
<?php } ?>

<section id="message-section" style="background-color: #f8d7da; padding: 20px; text-align: center; margin-top: 20px;">
    <div class="container">
        <h3 style="font-size: 24px; color: #721c24;">Get Your Tickets Now!</h3>
        <p style="font-size: 18px; color: #721c24;">Choose your preferred ticket type and enjoy the best experience with us. Don't miss out on our special offers!</p>
    </div>
</section>

<section id="feature" class="p_3">
  <div class="container-xl">
    <div class="feature_1 row">
      <div class="col-md-6">
        <div class="feature_1l clearfix">
          <h3 class="col_red">BOOK YOUR TICKETS NOW</h3>
          <form action="booking.php?movie_id=<?php echo $movie_id; ?>" method="POST">
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name:</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="last_name" class="form-label">Last Name:</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="age" class="form-label">Age:</label>
              <input type="number" class="form-control" id="age" name="age" min="1" required>
            </div>
            <div class="mb-3">
              <label for="ticket_type" class="form-label">Ticket Type:</label>
              <select class="form-control" id="ticket_type" name="ticket_type" required>
                <option value="silver">Silver - $500</option>
                <option value="gold">Gold - $1000</option>
                <option value="platinum">Platinum - $1500</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="payment_method" class="form-label">Payment Method:</label>
              <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="bank">Bank</option>
                <option value="jazzcash">JazzCash</option>
                <option value="easypaisa">EasyPaisa</option>
              </select>
            </div>
            <button type="submit" class="btn btn-danger">Submit Booking</button>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="feature_1r clearfix">
          <div class="grid clearfix">
            <figure class="effect-jazz mb-0">
              <a href="#"><img src="<?php echo $poster_url; ?>" class="w-100" alt="Booking Image" height="700px"></a>
            </figure>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include('footer.php');
?>
