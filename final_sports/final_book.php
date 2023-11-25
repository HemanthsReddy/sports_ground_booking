<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['timings']) && !empty($_POST['timings'])) {
        $user_id = $_SESSION['user_id'];
        $ground_id = mysqli_real_escape_string($conn, $_POST['ground_id']);
        $selected_date = mysqli_real_escape_string($conn, $_POST['selected_date']);
        $converted_date = date("Y-m-d", strtotime($selected_date));
        echo $converted_date;
        $last_booking_id_query = "SELECT MAX(booking_id) as last_booking_id FROM bookings";
        $last_booking_id_result = mysqli_query($conn, $last_booking_id_query);
        $last_booking_id_row = mysqli_fetch_assoc($last_booking_id_result);
        $next_booking_id = $last_booking_id_row['last_booking_id'] + 1;

        foreach ($_POST['timings'] as $timing) {
            $time_id = mysqli_real_escape_string($conn, $timing);

            $insert_booking_query = "INSERT INTO bookings (booking_id, time_id, user_id, ground_id, b_date) 
                                     VALUES ('$next_booking_id', '$time_id', '$user_id', '$ground_id', '$converted_date')";
            $result = mysqli_query($conn, $insert_booking_query);

            if (!$result) {
                die("Database error: " . mysqli_error($conn));
            }
        }

        echo "Booking successful!";
        header("Location: user_bookings.php");
    } else {
        echo "No timings selected!";
    }
} else {
    echo "Invalid request!";
}
?>
