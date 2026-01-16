<?php
include 'connection.php';
include 'header.php';
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Categories List</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Poster</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM category";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['category_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        $poster = !empty($row['poster']) ? $row['poster'] : 'img/default.jpg'; 
                                        echo "<td><img src='" . htmlspecialchars($poster) . "' alt='Poster' width='100'></td>";
                                        echo "<td>
                                                <a href='edit_category.php?category_id=" . $row['category_id'] . "' class='btn btn-primary'>Edit</a>
                                                <a href='delete_category.php?category_id=" . $row['category_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this category?\");'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No categories found.</td></tr>";
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
include 'footer.php';
?>
