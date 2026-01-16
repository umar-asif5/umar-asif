<?php
include('connection.php');

if (isset($_GET['payment_id'])) {
    $payment_id = (int) $_GET['payment_id'];
    $query = "SELECT * FROM payments WHERE payment_id = $payment_id";
    $result = mysqli_query($con, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $update_query = "UPDATE payments SET status = 'Refunded' WHERE payment_id = $payment_id";
        
        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Payment refunded successfully.'); window.location.href='view_payments.php';</script>";
        } else {
            echo "<script>alert('Error processing refund.');</script>";
        }
    } else {
        echo "<script>alert('Payment not found.'); window.location.href='view_payments.php';</script>";
    }
}
?>
