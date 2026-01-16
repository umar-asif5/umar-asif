<?php
include ('connection.php');

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']); 
} else {
    echo "No booking ID provided!";
    exit;
}

$query = "SELECT * FROM entry WHERE id = $booking_id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $ticket = mysqli_fetch_assoc($result);
    
    $first_name = $ticket['first_name'];
    $last_name = $ticket['last_name'];
    $email = $ticket['email'];
    $age = $ticket['age'];
    $ticket_type = $ticket['ticket_type'];
    $price = $ticket['price'];
    $payment_method = $ticket['payment_method'];

    
    echo "
    <style>
        body {
            background-color: #1c1c1c; 
            color: #fff; 
            font-family: 'Helvetica Neue', sans-serif;
        }
    
        .ticket-container {
            background: linear-gradient(135deg, #3f87a6, #ebf8e1);
            width: 650px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 3px solid #fff; 
            position: relative;
        }
    
        .ticket-container:before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: calc(100% + 40px);
            height: calc(100% + 40px);
            border: 3px dashed #fff;
            border-radius: 15px;
        }
    
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }
    
        .ticket-header h2 {
            font-size: 30px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
    
        .ticket-info {
            font-size: 16px;
            margin-bottom: 25px;
            color: #f1f1f1;
        }
    
        .ticket-info p {
            margin: 10px 0;
            font-weight: 600;
        }
    
        .ticket-footer {
            text-align: center;
            font-size: 18px;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 20px;
        }
    
        .ticket-footer p {
            margin-top: 15px;
        }
    
        .ticket-info strong {
            color: #ffd700;
        }
    
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
        }
    
        .ticket-btn {
            display: inline-block;
            margin-top: 30px;
            background: #f39c12;
            color: #fff;
            font-size: 18px;
            padding: 12px 25px;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
    
        .ticket-btn:hover {
            background: #e67e22;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
    
        .r1 {
            text-align: center;
            font-size: 30px;
            color: red;
        }
    
       .btn-secondary {
    display: inline-block;
    background: #555; 
    color: #fff;
    font-size: 18px;
    padding: 12px 25px;
    text-decoration: none;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    cursor: pointer; /* Ensure it's clickable */
    z-index: 10; /* Ensure it is on top of other elements */
    position: relative; /* Ensure the button is positioned correctly */
}

.btn-secondary:hover {
    background: #444;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

    
    </style>
    
    <section id='ticket-section'>
        <div class='ticket-container'>
            <div class='ticket-header'>
                <h2>Booking Confirmation</h2>
            </div>
    
            <div class='ticket-info'>
                <p><strong>Name:</strong> $first_name $last_name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Age:</strong> $age years old</p>
                <p><strong>Ticket Type:</strong> $ticket_type</p>
                <p><strong>Price:</strong> $$price</p>
                <p><strong>Payment Method:</strong> $payment_method</p>
            </div>
    
            <div class='ticket-footer'>
                <p>Thank you for booking with us!</p>
            </div>
    
            <!-- Back button to navigate to the previous page -->
            <button type='button' class='btn-secondary' onclick='goBack();'>Back</button>
        </div>
        <script>
function goBack() {
    if (document.referrer) {
        window.history.back(); // Go to the previous page
    } else {
        // If no history exists, redirect to a default page like homepage or booking page
        window.location.href = 'index.php'; // Or any other page you want to redirect to
    }
}
</script>
    </section>
    ";
    
    
} else {
    echo "<div class='error-message'>Error: No ticket found!</div>";
}
?>

<h2 class="r1">Capture This</h2>
