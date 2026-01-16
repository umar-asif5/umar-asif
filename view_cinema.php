<?php
include('connection.php');
include('header.php');

$query = "SELECT * FROM cinemas";
$result = mysqli_query($con, $query);
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Cinemas List</h4>
                        
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-bordered text-light'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Location</th>
                                            <th>Total Screens</th>
                                            <th>Poster</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                $cinema_id = $row['cinema_id'];
                                $poster_url = $row['poster_url'];

                                echo "<tr>
                                        <td>{$row['cinema_id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['location']}</td>
                                        <td>{$row['total_screens']}</td>
                                        <td>";
                                if ($poster_url) {
                                    echo "<img src='../img/" . basename($poster_url) . "' alt='Poster' style='max-width: 100px; height: auto;'>";
                                } else {
                                    echo "No poster available";
                                }
                                echo "</td>
                                        <td>
                                            <a href='edit_cinema.php?cinema_id=$cinema_id' class='btn btn-primary btn-sm'>Edit</a>
                                            <a href='delete_cinema.php?cinema_id=$cinema_id' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this cinema?\");'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p>No cinemas found.</p>";
                        }

                        $con->close();
                        ?>
                    </div>  
                </div>    
            </div>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>
