<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    include_once 'db_connection.php'; // Include your database connection file

    $userId = $_SESSION['user_id'];

    // Replace this query with the appropriate query to fetch booking details
    $query = "CALL GetUserBookings('$userId')";
    
    // Execute the query and fetch results
    $result = mysqli_query($conn, $query);

    // Check if there are rows in the result set
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch booking details from the result set
        $bookingDetails = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $bookingDetails = []; // Empty array if no bookings found
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Bookings</title>
        <link rel="stylesheet" href="user_booking_style.css">
    </head>
    <body>
    <div class="container">
        <h2>User Bookings</h2>

        <!-- Display booking details table -->
        <table>
            <tr>
                <th style="text-align: center;">Booking ID</th>
                <th style="text-align: center;">Ground </th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Time </th>
                <th style="text-align: center;">Cancel Booking</th>
            </tr>
            <?php foreach ($bookingDetails as $booking) : ?>
                <?php
                // Get the date from the booking
                $bookingDate = date('Y-m-d', strtotime($booking['b_date']));

                // Get tomorrow's date
                $tomorrowDate = date('Y-m-d', strtotime('+1 day'));

                // Check if the booking date is tomorrow or later
                $isCancelable = strtotime($bookingDate) >= strtotime($tomorrowDate);
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $booking['booking_id']; ?></td>
                    <td style="text-align: center;"><?php echo $booking['ground_name']; ?></td>
                    <td style="text-align: center;"><?php echo $booking['b_date']; ?></td>
                    <td style="text-align: center;"><?php echo $booking['start_time'];  echo " - "; echo $booking['end_time'] ; ?></td>
                    <!-- Display Cancel Booking button if the booking is cancelable -->
                    <td style="text-align: center;">
                        <?php if ($isCancelable) : ?>
                            <a href="cancel_booking.php?booking_id=<?php echo $booking['booking_id']; ?>&time_id=<?php echo $booking['time_id']; ?>" class="cancel-btn">Cancel Booking</a>
                        <?php endif; ?>
                    </td>
                </tr>
                
            <?php endforeach; ?>
        </table>

        <a href="user_profile.php" class="back-btn">Back to User Profile</a>
        <a href="home4.php" class="back-btn">Back to Home</a> 
    </div>
    </body>
    </html>

    <?php
} else {
    header("Location: index.php");
    exit();
}
