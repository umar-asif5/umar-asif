<?php
include 'connection.php';

if (isset($_GET['role_id'])) {
    $id = $_GET['role_id']; 

    $qq = "DELETE FROM roles WHERE role_id=$id";
    $result = mysqli_query($con, $qq);

    if ($result) {
        echo "<script>alert('Record Deleted'); window.location.href='view_roles.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='view_roles.php';</script>";
    }
} else {
    echo "<script>alert('Invalid ID'); window.location.href='view_roles.php';</script>";
}
?>