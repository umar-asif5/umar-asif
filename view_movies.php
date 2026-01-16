<?php
include('header.php');
include('connection.php');

$query = "SELECT m.*, c.name AS category_name FROM movies m 
          LEFT JOIN category c ON m.category_id = c.category_id";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Movies List</h4>
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Release Date</th>
                                    <th>Rating</th>
                                    <th>Genre</th>
                                    <th>Category</th> 
                                    <th>Poster</th>
                                    <th>Trailer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['movie_id'] . "</td>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['duration'] . " mins</td>";
                                        echo "<td>" . $row['release_date'] . "</td>";
                                        echo "<td>" . $row['rating'] . "</td>";
                                        echo "<td>" . $row['genre'] . "</td>";
                                        echo "<td>" . $row['category_name'] . "</td>"; 
                                        echo "<td><img src='" . $row['poster_url'] . "' alt='Poster' style='width: 100px; height: 50px'></td>";
                                        echo "<td><video width='100' height='50' controls>
                                                  <source src='" . $row['trailer_url'] . "' type='video/mp4'>
                                                  Your browser does not support the video tag.
                                                  </video></td>";

                                        echo "<td>
                                                <a href='edit_movies.php?movie_id=" . $row['movie_id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                                <a href='delete_movies.php?movie_id=" . $row['movie_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this movie?\");'>Delete</a>
                                                <a href='reviews.php?movie_id=" . $row['movie_id'] . "' class='btn btn-success btn-sm'>View Reviews</a> <!-- New Button --> 
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='11'>No movies found.</td></tr>"; 
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
