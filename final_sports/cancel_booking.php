<?php
session_start();
include_once 'db_connection.php';

if (isset($_SESSION['user_id']) && isset($_GET['booking_id']) && isset($_GET['time_id'])) {
    $user_id = $_SESSION['user_id'];
    $booking_id = mysqli_real_escape_string($conn, $_GET['booking_id']);
    $time_id = mysqli_real_escape_string($conn, $_GET['time_id']);

    // Check if the booking belongs to the logged-in user
    $check_booking_query = "SELECT * FROM bookings WHERE user_id = '$user_id' AND booking_id = '$booking_id'";
    $check_booking_result = mysqli_query($conn, $check_booking_query);

    if ($check_booking_result && mysqli_num_rows($check_booking_result) > 0) {
        // Booking belongs to the user, proceed with cancellation
        $cancel_booking_query = "DELETE FROM bookings WHERE booking_id = '$booking_id' AND time_id = '$time_id'";
        $cancel_booking_result = mysqli_query($conn, $cancel_booking_query);

        if ($cancel_booking_result) {
            // Booking successfully canceled
            header("Location: user_bookings.php");
            exit();
        } else {
            echo "Error canceling booking: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid booking ID or unauthorized access.";
    }
} else {
    echo "Invalid request.";
}
?>
