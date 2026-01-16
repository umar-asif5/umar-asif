<?php
include('connection.php'); 
include('header.php');

if (!$con) {
    die('Database connection failed: ' . mysqli_connect_error());
}

function get_reviews($movie_id) {
    global $con;

    $sql = "SELECT r.review_id, r.rating, r.comment, r.review_date, u.username, m.title AS movie_title
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        JOIN movies m ON r.movie_id = m.movie_id
        WHERE r.movie_id = $movie_id
        ORDER BY r.review_date DESC";

    $result = mysqli_query($con, $sql);

    $reviews = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }

    return $reviews;
}

function approve_review($review_id) {
    global $con;

    $sql = "UPDATE reviews SET is_approved = 1 WHERE review_id = $review_id";

    mysqli_query($con, $sql);
}

function flag_review($review_id) {
    global $con;

    $sql = "UPDATE reviews SET is_flagged = 1 WHERE review_id = $review_id";

    mysqli_query($con, $sql);
}

function delete_review($review_id) {
    global $con;

    $sql = "DELETE FROM reviews WHERE review_id = $review_id";

    mysqli_query($con, $sql);
}

if (isset($_POST['action'])) {
    $review_id = (int)$_POST['review_id'];

    switch ($_POST['action']) {
        case 'approve':
            approve_review($review_id);
            $message = 'Review approved!';
            break;
        case 'flag':
            flag_review($review_id);
            $message = 'Review flagged!';
            break;
        case 'delete':
            delete_review($review_id);
            $message = 'Review deleted!';
            break;
        default:
            $message = 'Invalid action!';
            break;
    }

    echo "<script>alert('$message');</script>";
}

if (isset($_GET['movie_id'])) {
    $movie_id = (int)$_GET['movie_id'];

    $reviews = get_reviews($movie_id);

    $movie_title_query = "SELECT title FROM movies WHERE movie_id = $movie_id";
    $movie_title_result = mysqli_query($con, $movie_title_query);
    $movie_title = mysqli_fetch_assoc($movie_title_result)['title'];
} else {
    die("Movie ID is required!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Reviews</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Reviews for "<?php echo htmlspecialchars($movie_title); ?>"</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($reviews): ?>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($review['username']); ?></td>
                        <td><?php echo htmlspecialchars($review['rating']); ?></td>
                        <td><?php echo htmlspecialchars($review['comment']); ?></td>
                        <td><?php echo htmlspecialchars($review['review_date']); ?></td>
                        <td>
                            <?php if ($review['is_approved'] == 0): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                    <button type="submit" name="action" value="approve">Approve</button>
                                </form>
                            <?php endif; ?>
                            
                            <?php if ($review['is_flagged'] == 0): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                    <button type="submit" name="action" value="flag">Flag</button>
                                </form>
                            <?php endif; ?>

                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                                <button type="submit" name="action" value="delete" onclick="return confirm('Are you sure you want to delete this review?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No reviews found for this movie.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="view_movies.php">Back to Movie List</a>
</body>
</html>

<?php
include('footer.php');
?>
