<?php
include('connection.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $message_id = $_GET['id'];

    $query = "DELETE FROM contact_messages WHERE id = ?";
    
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param('i', $message_id);

        if ($stmt->execute()) {
            echo "<script>alert('Message deleted successfully.'); window.location.href = 'contect.php';</script>";
        } else {
            echo "<script>alert('Error deleting message. Please try again later.'); window.location.href = 'contect.php';</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the query.'); window.location.href = 'contect.php';</script>";
    }
} else {
    echo "<script>alert('Invalid message ID.'); window.location.href = 'contect.php';</script>";
}

$con->close();
?>
