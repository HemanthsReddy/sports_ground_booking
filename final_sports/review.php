<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page</title>
    <link rel="stylesheet" href="review.css"> <!-- Link to your CSS file -->
</head>
<body>

    <header>
        <div class="header-container">
            <img style="margin-left: 50px;" src="logo.png" alt="Logo">
            <h1>Playo</h1>
            <a href="home4.php"><button style="margin-right: 50px;">Back to home</button></a>
        </div>
    </header>

    <form class="main-container" action="submit_review.php" method="post">
    <!-- Existing Reviews Section -->
    <div class="existing-reviews">
        <h2>Reviews</h2>
        <?php
        // Include your database connection here
        include "db_connection.php";

        // Fetch existing reviews for the given ground_id
        $ground_id = mysqli_real_escape_string($conn, $_GET['ground_id']);
        $reviews_query = "SELECT * FROM review WHERE groundid = '$ground_id'";
        $reviews_result = mysqli_query($conn, $reviews_query);

        if ($reviews_result) {
            while ($row = mysqli_fetch_assoc($reviews_result)) {
                echo '<div class="review-container">';
                echo '<p>Review ID: ' . $row['review_id'] . '</p>';
                echo '<p>Rating: ' . $row['rating'] . '</p>';
                echo '<p>Review: ' . $row['review'] . '</p>';
                echo '</div>';
            }
        } else {
            echo 'Error fetching reviews: ' . mysqli_error($conn);
        }
        ?>
    </div>
    <div class="new-review">
        <h2>Add your review</h2>
        <div class="rating-container">
            <label for="rating">Rate:</label>
            <div class="rating">
                <input type="radio" name="rating" value="1" id="star1"><label for="star1">1</label>
                <input type="radio" name="rating" value="2" id="star2"><label for="star2">2</label>
                <input type="radio" name="rating" value="3" id="star3"><label for="star3">3</label>
                <input type="radio" name="rating" value="4" id="star4"><label for="star4">4</label>
                <input type="radio" name="rating" value="5" id="star5"><label for="star5">5</label>
            </div>
        </div>

        <div class="new-review-container">
            <label for="review">Review:</label>
            <textarea name="review" id="review" rows="4" cols="50"></textarea>

            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
            <input type="hidden" name="ground_id" value="<?php echo $_GET['ground_id']; ?>">

            <button type="submit">Submit Review</button>
        </div>
    </div>
    <!-- Existing Reviews Section -->
    
    </form>
</body>
</html>
