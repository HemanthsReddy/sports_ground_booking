<?php
// Include your database connection here
include "db_connection.php";

// Check if the selectedDate and groundId are provided in the GET request
if (isset($_GET['selectedDate']) && isset($_GET['groundId'])) {
    $selectedDate = mysqli_real_escape_string($conn, $_GET['selectedDate']);
    $groundId = mysqli_real_escape_string($conn, $_GET['groundId']);
    // Call the GetAvailableTimings stored procedure with both parameters
    $result = mysqli_query($conn, "CALL GetAvailableTimings('$selectedDate', '$groundId')");
    
    if (!$result) {
        die("Database error: " . mysqli_error($conn));
    }

    // Fetch the results
    $timings = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // Free the result set
    mysqli_free_result($result);

    // Return the results as JSON
    echo json_encode($timings);
} else {
    // Return an error message if selectedDate or groundId is not provided
    echo json_encode(['error' => 'selectedDate or groundId parameter is missing']);
}
?>
