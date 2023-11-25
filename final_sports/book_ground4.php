<?php
// Add your database connection here
include "db_connection.php";

// Check if a search query is provided
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']); // Sanitize the search input

    // Query the database for grounds that match the search query
    $search_sql = "SELECT grounds.*, sports.sport_name
    FROM grounds
    JOIN sports ON grounds.sportid = sports.sport_id
    WHERE grounds.ground_name LIKE '%$search%' OR sports.sport_name LIKE '%$search%';
    ";
    $search_result = mysqli_query($conn, $search_sql);

    if (!$search_result) {
        die("Database error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="book_ground4.css">
</head>
<body>
<header>
        <div class="header-container">
            <img style="margin-left: 50px;" src="logo.png" alt="Logo">
            <h1 style="font-size: 30;">Playo</h1>
            <a href="user_profile.php"><button style="margin-right: 50px;">User Profile</button></a>
            <!-- <a href="logout.php"><button style="margin-right: 50px;">Logout</button></a> -->
        </div>
    </header>

    <h2 class="search-results-section">Search Results</h2>

    <div class="results-container">
        <?php
        if (isset($search_result) && mysqli_num_rows($search_result) > 0) {
            while ($row = mysqli_fetch_assoc($search_result)) { 
                ?>
                <main class="result-item">
                    <?php echo "<img src='images/".$row['image']."'>";?>
                    <div class="ground-details">
                        <p class="ground-name"><?php echo $row['ground_name']; ?></p>
                        <p class="location">Location: <?php echo $row['location']; ?></p>
                        <p class="price">Price: <?php echo $row['price']; ?></p>
                        <a href="booking_page2.php?ground_id=<?php echo $row['ground_id']; ?>"><button class="book-button">Book</button></a>

                    </div>
                </main>
                <?php
            }
        } else {
            echo "<p>No results found.</p>";
        }
        ?>
    </div>
</body>
</html>
