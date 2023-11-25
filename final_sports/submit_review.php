<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $ground_id = mysqli_real_escape_string($conn, $_POST['ground_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    // Calculate the next review_id
    $next_review_id_query = "SELECT MAX(review_id) as max_review_id FROM review";
    $next_review_id_result = mysqli_query($conn, $next_review_id_query);
    $next_review_id_row = mysqli_fetch_assoc($next_review_id_result);
    $next_review_id = $next_review_id_row['max_review_id'] + 1;

    // Insert the review into the database
    $insert_review_query = "INSERT INTO review (review_id, userid, groundid, rating, review) 
                            VALUES ('$next_review_id', '$user_id', '$ground_id', '$rating', '$review')";

    $result = mysqli_query($conn, $insert_review_query);

    if ($result) {
        header("Location: booking_page2.php?ground_id=$ground_id");
        exit();
    } else {
        echo "Error submitting review: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
