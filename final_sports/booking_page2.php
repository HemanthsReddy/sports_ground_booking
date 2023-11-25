<?php
session_start();
// Include your database connection here
include "db_connection.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Check if the ground_id is provided in the URL
if (isset($_GET['ground_id'])) {
    $ground_id = mysqli_real_escape_string($conn, $_GET['ground_id']);

    // Query the database to get information about the selected ground
    $ground_info_sql = "SELECT * FROM grounds WHERE ground_id = '$ground_id'";
    $ground_info_result = mysqli_query($conn, $ground_info_sql);

    if (!$ground_info_result) {
        die("Database error: " . mysqli_error($conn));
    }
    $ground_info = mysqli_fetch_assoc($ground_info_result);

    // Code below to get details of sport related to the ground
    $sportid = $ground_info['sportid'];
    $sport_info_sql = "SELECT * FROM sports WHERE sport_id = '$sportid'";
    $sport_info_result = mysqli_query($conn, $sport_info_sql);

    if (!$sport_info_result) {
        die("Database error: " . mysqli_error($conn));
    }
    $sport_info = mysqli_fetch_assoc($sport_info_result);

} else {
    // Redirect to the search results page if ground_id is not provided
    header("Location: book_ground4.php");
    exit();
}
?>

<?php
// Calculate the date range
$today = date("Y-m-d");
$maxDate = date("Y-m-d", strtotime("+20 days"));

// Send the date range to the client side
echo '<script>
    var minDate = "' . $today . '";
    var maxDate = "' . $maxDate . '";
    var groundId = "' . $ground_info['ground_id'] . '";
</script>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" type="text/css" href="booking_page.css">
    <!-- Add jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add jQuery UI library -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <header>
        <div class="header-container">
            <img style="margin-left: 50px;" src="logo.png" alt="Logo">
            <h1>Playo</h1>
            <a href="user_profile.php"><button style="margin-right: 50px;">User Profile</button></a>
            <a href="logout.php"><button style="margin-right: 50px;">Logout</button></a>
        </div>
    </header>

    <div class="main-container">
        <div class="image-container">
            <h2 style="font-size: 40 ;margin-left : 20px ; color: rgb(47 72 88);"><?php echo $ground_info['ground_name']; ?> - <?php echo $ground_info['location']; ?> </h2>
            <?php echo "<img src='images/".$ground_info['image']."'>";?>
        </div>

        <div class="details-container">
            <!-- <div class="basic-container"> -->
                <div class="basic-container">
                <a href="review.php?user_id=<?php echo $_SESSION['user_id']; ?>&ground_id=<?php echo $ground_info['ground_id']; ?>">
                    <button style="width: 100%; display: block; height: 50px">Review this ground</button>
                </a>
                </div>
            <div class="basic-container">
                <p class="location">Sport: <?php echo $sport_info['sport_name']; ?></p>
                <p class="location">Price: <?php echo $ground_info['price']; ?>/ hour</p>
            </div>
            <div class="basic-container">
                <label for="datepicker">Select Date:</label>
                <input type="text" id="datepicker" name="datepicker">
                <button id="select-time-btn">Select Time</button>
            </div>
            <div class="basic-container">
                <form id="booking-form" action="final_book.php" method="post">
                <input type="hidden" name="ground_id" value="<?php echo $ground_info['ground_id']; ?>">
                <!-- <input type="hidden" name="selected_date" id="selected-date-input" value=""> -->
                    <div id="timings-container">
    <!-- Timings will be dynamically added here -->
                    </div>
                    <div id="confirm-button">
                        <!-- Confirm button will be added here -->
                    </div>
                    <div id="price-container">
                        <!-- Price will be dynamically added here -->
                    </div>
                    <div id="book-button">
                        <!-- Book Now button will be added here -->
                    </div>
                </form>
            </div>
            <!-- </div> -->
        </div>
    </div>

    <script>
        // Function to fetch and display available timings
        function showAvailableTimings(selectedDate, groundId) {
            console.log('AJAX URL:', 'get_available_timings.php?selectedDate=' + selectedDate + '&groundId=' + groundId);

            $.ajax({
                url: 'get_available_timings.php',
                type: 'GET',
                data: { selectedDate: selectedDate , groundId: groundId},
                dataType: 'json',
                success: function (response) {
                    // Clear existing timings
                    $('#timings-container').empty();
                    // Display timings inside boxes
                    if(response.length === 0)
                    {
                        $('#timings-container').append('<h2 >No Timings Available for this date</h2>');
                    }
                    else{
                    for (var i = 0; i < response.length; i++) {
                        var timing = response[i];
                        var timingBox = $('<div class="timing-box"><label><input type="checkbox" name="timings[]" value="' + timing.time_id + '"> ' + timing.start_time + '-' + timing.end_time + '</label></div>');
                        $('#timings-container').append(timingBox);
                    }

                    var confirmButton = $('<button style="width: 100%; display: block;" type="button" id="confirm-btn" disabled>CONFIRM</button>');
                    $('#confirm-button').html(confirmButton);

                    // Attach an event listener to the "CONFIRM" button
                    $(document).on('click', '#confirm-btn', function () {
                        console.log('confirm');
                        var selectedDate = $('#confirm-btn').data('selected-date');
                        calculateAndDisplayPrice(selectedDate);
                        

                    });
                    
                    $('#booking-form').append('<input type="hidden" name="selected_date" value="' + selectedDate + '">');
                    
                    $(document).on('change', 'input[type="checkbox"]', function () {
                        // Check if at least one checkbox is checked
                        if ($('input[type="checkbox"]:checked').length > 0) {
                            // Enable the "BOOK NOW" button
                            $('#confirm-btn').prop('disabled', false);
                        } else {
                            // Disable the "BOOK NOW" button
                            $('confirm-btn').prop('disabled', true);
                        }
                    });

                    
                    
                    // Attach an event listener to the "BOOK NOW" button
                    $(document).on('click', '#book-now-btn', function () {
                        // Submit the form
                        console.log('book-now');
                        $('#booking-form').submit();
                    });

                    
                }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching timings:', error);
                    console.log('XHR:', xhr);
                    console.log('Status:', status);
                }
            });
        }

        function calculateAndDisplayPrice(selectedDate) {
        var selectedTimings = $('input[type="checkbox"]:checked').length;
        if (selectedTimings===0){
            $('#price-container').empty();
            $('#book-button').empty();
            return;
        }
        var pricePerHour = <?php echo $ground_info['price']; ?>;
        var totalPrice = selectedTimings * pricePerHour;

        // Display the total price
        var priceContainer = $('<div><p>Total Price: $' + totalPrice + '</p></div>');
        $('#price-container').html(priceContainer);

        // Add the "BOOK NOW" button

        var bookButton = $('<button style = "width: 100%; display:block;" type="button" id="book-now-btn" >BOOK NOW</button>');
        $('#book-button').html(bookButton);
                    
        // Add the "BOOK NOW" button
        
        // var bookNowButton = $('<button style="width: 100%; display: block;" type="button" id="book-now-btn" disabled>BOOK NOW</button>');
        // $('#book-button').html(bookNowButton);

        // Attach an event listener to the "BOOK NOW" button
        $(document).on('click', '#book-now-btn', function () {
            // Submit the form
            console.log('book-now');
            $('#booking-form').submit();
        });
        }

        // Attach an event listener to the "Select Time" button
        $(document).on('click', '#select-time-btn', function () {
            var selectedDate = $('#datepicker').val();
            // var groundId = $ground_id;
            if (selectedDate.trim() !== '') {
            // var groundId = $ground_id;
            showAvailableTimings(selectedDate, groundId);
            // console.log('Button clicked!');
            // console.log(selectedDate);
            } else {
                // Handle the case where selectedDate is empty (do nothing or show an alert)
                console.log('Selected date is empty. Please choose a date.');
                $('#timings-container').empty();
                $('#confirm-button').empty();
                // You can also show an alert or perform other actions to notify the user.
            }
            console.log('Button clicked!');
            console.log(selectedDate)
        });

        $(document).on('click', '#book-now-btn', function () {
            // Submit the form
            console.log('book-now');
            $('#booking-form').submit();
        });
        // Initialize datepicker with minDate and maxDate
        $(function () {
            $("#datepicker").datepicker({
                minDate: new Date(minDate),
                maxDate: new Date(maxDate)
            });
        });
    </script>
</body>
</html>
