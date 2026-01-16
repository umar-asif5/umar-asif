<?php
include('connection.php');

if (isset($_GET['cinema_id'])) {
    $cinema_id = $_GET['cinema_id'];

    $delete_query = "DELETE FROM cinemas WHERE cinema_id = $cinema_id";

    if (mysqli_query($con, $delete_query)) {
        echo "<script>alert('Cinema deleted successfully!'); window.location.href='view_cinema.php';</script>";
    } else {
        echo "<script>alert('Error deleting cinema: " . mysqli_error($con) . "'); window.location.href='view_cinema.php';</script>";
    }
} else {
    echo "<script>alert('Cinema ID not specified.'); window.location.href='view_cinema.php';</script>";
}

mysqli_close($con);
?>
