<?php
session_start();
include_once 'db_connection.php';

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
    $adminId = $_SESSION['admin_id'];

    // Fetch grounds listed by the admin
    $groundsQuery = "SELECT ground_id FROM grounds WHERE g_owner = ?";
    $stmtGrounds = $conn->prepare($groundsQuery);
    $stmtGrounds->bind_param("s", $adminId);
    $stmtGrounds->execute();
    $resultGrounds = $stmtGrounds->get_result();

    // Fetch reviews for the grounds listed by the admin
    $reviews = array();
    while ($rowGrounds = $resultGrounds->fetch_assoc()) {
        $groundId = $rowGrounds['ground_id'];
        $reviewsQuery = "SELECT * FROM review WHERE groundid = ?";
        $stmtReviews = $conn->prepare($reviewsQuery);
        $stmtReviews->bind_param("s", $groundId);
        $stmtReviews->execute();
        $resultReviews = $stmtReviews->get_result();

        while ($rowReview = $resultReviews->fetch_assoc()) {
            $reviews[] = $rowReview;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reviews</title>
    <link rel="stylesheet" type="text/css" href="admin_reviews.css">
</head>

<body>
    <div class="container">
        <h2>Admin Reviews</h2>

        <table>
            <tr>
                <th>Review ID</th>
                <th>Rating</th>
                <th>Review</th>
            </tr>

            <?php
            foreach ($reviews as $review) {
                echo "<tr>";
                echo "<td>" . $review['review_id'] . "</td>";
                echo "<td>" . $review['rating'] . " </td>";
                echo "<td>" . $review['review'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>

<?php
} else {
    header("Location: admin_login.php");
    exit();
}
?>
