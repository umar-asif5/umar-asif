<?php
include('connection.php');
include('header.php');


if (isset($_GET['payment_id'])) {
    $payment_id = (int) $_GET['payment_id'];
    $query = "SELECT * FROM payments WHERE payment_id = $payment_id";
    $result = mysqli_query($con, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_status = $_POST['status'];
            $update_query = "UPDATE payments SET status = '$new_status' WHERE payment_id = $payment_id";
            
            if (mysqli_query($con, $update_query)) {
                echo "<script>alert('Payment status updated successfully.'); window.location.href='view_payments.php';</script>";
            } else {
                echo "<script>alert('Error updating payment status.');</script>";
            }
        }
    } else {
        echo "<script>alert('Payment not found.'); window.location.href='view_payments.php';</script>";
    }
}

?>
<form method="POST">
    <h2>Update Payment Status</h2>
    <label for="status">Payment Status:</label>
    <select name="status" required>
        <option value="Pending">Pending</option>
        <option value="Completed">Completed</option>
        <option value="Failed">Failed</option>
    </select>
    <br>
    <button type="submit">Update Status</button>
</form>
<?php
include('footer.php');
?>