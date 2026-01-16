<?php
include('connection.php');
include('header.php');

// SQL query to fetch data from the `contact_messages` table
$query = "
    SELECT id, name, email, phone, message, created_at
    FROM contact_messages
    ORDER BY created_at DESC
";
$result = mysqli_query($con, $query);
?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bg-dark text-light">
                    <h4 class="card-title">View Contact Messages</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Message ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>"; // Format message and handle special chars
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>
                                            <a href='delete_message.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No messages found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>    
            </div>
        </div>
    </div>
</div>

<?php
$con->close();
include('footer.php');
?>
