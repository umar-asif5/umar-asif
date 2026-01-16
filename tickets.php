<?php
include('connection.php');
include('header.php');

// SQL query to fetch data from the `entry` table
$query = 'SELECT id, first_name, last_name, email, age, ticket_type, price, payment_method, booking_date 
          FROM entry';

$result = mysqli_query($con, $query);
?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bg-dark text-light">
                    <h4 class="card-title">Ticket Management</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Entry ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Ticket Type</th>
                                <th>Price</th>
                                <th>Payment Method</th>
                                <th>Booking Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['first_name'] . "</td>";
                                    echo "<td>" . $row['last_name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['age'] . "</td>";
                                    echo "<td>" . $row['ticket_type'] . "</td>";
                                    echo "<td>$" . number_format($row['price'], 2) . "</td>";
                                    echo "<td>" . $row['payment_method'] . "</td>";
                                    echo "<td>" . $row['booking_date'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No entries found.</td></tr>";
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
include('footer.php');
?>
