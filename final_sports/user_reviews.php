<?php
session_start();
include_once 'db_connection.php';

if(isset($_SESSION['user_id']) && isset($_SESSION['username'])){
    $userId = $_SESSION['user_id'];

    // Fetch all reviews submitted by the user
    $reviewsQuery = "SELECT * FROM review WHERE userid = ?";
    $stmtReviews = $conn->prepare($reviewsQuery);
    $stmtReviews->bind_param("s", $userId);
    $stmtReviews->execute();
    $resultReviews = $stmtReviews->get_result();

    // Fetch user information for display
    $userInfoQuery = "SELECT * FROM users WHERE user_id = ?";
    $stmtUserInfo = $conn->prepare($userInfoQuery);
    $stmtUserInfo->bind_param("s", $userId);
    $stmtUserInfo->execute();
    $resultUserInfo = $stmtUserInfo->get_result();
    $userInfo = $resultUserInfo->fetch_assoc();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews</title>
    <link rel="stylesheet" href="user_reviews.css">
</head>

<body>
    <div class="container">
        <h2>User Reviews</h2>

        <div class="user-info">
            <p>Username: <?php echo $userInfo['username']; ?></p>
            <p>Name: <?php echo $userInfo['fname'] . ' ' . $userInfo['lname']; ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>Rating</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultReviews->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['review_id']; ?></td>
                        <td><?php echo $row['rating']; ?></td>
                        <td><?php echo $row['review']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="user_profile.php" class="back-btn">Back to Profile</a>
    </div>
</body>

</html>
