<?php
include('connection.php');
include('header.php');  

$query = "SELECT * FROM roles";
$result = mysqli_query($con, $query);
?>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body bg-dark text-light">
                        <h4 class="card-title">Roles List</h4>
                        
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            echo "<table class='table table-bordered text-light'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Role Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                $role_id = $row['role_id'];
                                echo "<tr>
                                        <td>{$row['role_id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>
                                            <a href='edit_roles.php?role_id=$role_id' class='btn btn-primary btn-sm'>Edit</a>
                                            <a href='delete_roles.php?role_id=$role_id' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this role?\");'>Delete</a>
                                        </td>
                                      </tr>";
                            }

                            echo "</tbody></table>";
                        } else {
                            echo "<p>No roles found.</p>";
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
