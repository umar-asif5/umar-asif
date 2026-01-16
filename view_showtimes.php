<?php
include('connection.php');
include('header.php');

$sql = "SELECT st.showtime_id, m.title AS movie_title, c.name AS cinema_name, 
               s.screen_number, st.showtime 
        FROM showtimes st
        JOIN movies m ON st.movie_id = m.movie_id
        JOIN screens s ON st.screen_id = s.screen_id
        JOIN cinemas c ON s.cinema_id = c.cinema_id";
$result = mysqli_query($con, $sql);

if (isset($_GET['delete_id'])) {
    $showtime_id = (int)$_GET['delete_id'];
    $delete_sql = "DELETE FROM showtimes WHERE showtime_id = ?";
    $stmt = mysqli_prepare($con, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $showtime_id);

    if (mysqli_stmt_execute($stmt)) {
        $message = 'Showtime deleted successfully!';
    } else {
        $message = 'Error deleting showtime: ' . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
    echo "<script>alert('$message');window.location.href='view_showtimes.php';</script>";
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">View Showtimes</h4>

                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Movie</th>
                                    <th>Cinema</th>
                                    <th>Screen Number</th>
                                    <th>Showtime</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['showtime_id']}</td>
                <td>{$row['movie_title']}</td>
                <td>{$row['cinema_name']}</td>
                <td>{$row['screen_number']}</td>
                <td>{$row['showtime']}</td>
                <td>
                    <a href='edit_showtimes.php?showtime_id={$row['showtime_id']}' class='btn btn-danger btn-sm'>Edit</a>
                    <a href='view_showtimes.php?delete_id={$row['showtime_id']}' 
                       onclick='return confirm(\"Are you sure you want to delete this showtime?\")' 
                       class='btn btn-danger btn-sm'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No showtimes found!</td></tr>";
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
