<?php
include('connection.php');
include('header.php');  

if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $screen_id = $_POST['screen_id'];

    $delete_showtimes_query = "DELETE FROM showtimes WHERE screen_id = ?";
    $stmt_showtimes = mysqli_prepare($con, $delete_showtimes_query);
    mysqli_stmt_bind_param($stmt_showtimes, "i", $screen_id);
    mysqli_stmt_execute($stmt_showtimes);

    $delete_query = "DELETE FROM screens WHERE screen_id = ?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $screen_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Screen deleted successfully.');
                window.location.href = 'view_screens.php'; 
              </script>";
        exit();
    } else {
        echo "<script>alert('Error deleting screen.');</script>";
    }
    
}

$query = "SELECT * FROM screens";
$result = mysqli_query($con, $query);
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Screens List</h4>
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cinema</th>
                                    <th>Screen Number</th>
                                    <th>Capacity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>{$row['screen_id']}</td>
                                                <td>{$row['cinema_id']}</td>
                                                <td>{$row['screen_number']}</td>
                                                <td>{$row['capacity']}</td>
                                                <td>
                                                    <!-- Edit Screen -->
                                                    <a href='edit_screens.php?screen_id={$row['screen_id']}' class='btn btn-danger'>Edit</a>

                                                    <!-- Delete Screen -->
                                                    <form method='POST' action='' style='display:inline'>
                                                        <input type='hidden' name='screen_id' value='{$row['screen_id']}'>
                                                        <button type='submit' name='action' value='delete' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this screen?\");'>Delete</button>
                                                    </form>
                                                </td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No screens found!</td></tr>";
                                }
                                ?>
                            </tbody>
                         </table>
                    </div>  
                </div>    
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');  
?>
