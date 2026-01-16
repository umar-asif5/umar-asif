<?php
include 'connection.php';

if (isset($_GET['category_id'])) {
    $id = $_GET['category_id']; 

    $qq = "DELETE FROM category WHERE category_id=$id";
    $result = mysqli_query($con, $qq);

    if ($result) {
        echo "<script>alert('Record Deleted'); window.location.href='view_category.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='view_category.php';</script>";
    }
} else {
    echo "<script>alert('Invalid ID'); window.location.href='view_category.php';</script>";
}
?>