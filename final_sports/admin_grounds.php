<?php
session_start();
include_once 'db_connection.php';

if (isset($_SESSION['admin_id']) && isset($_SESSION['username'])) {
    $adminId = $_SESSION['admin_id'];

    // Fetch grounds associated with the admin_id
    $groundsQuery = "SELECT * FROM grounds WHERE g_owner = '$adminId'";
    $groundsResult = mysqli_query($conn, $groundsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Grounds</title>
    <link rel="stylesheet" href="admin_grounds.css"> <!-- You can create a separate CSS file for styling -->
</head>
<body>
    <div class="container">
        <h2>Admin Grounds</h2>

        <?php if (mysqli_num_rows($groundsResult) > 0) { ?>
            <table>
                <tr>
                    <th>Ground ID</th>
                    <th>Location</th>
                    <th>Ground Name</th>
                    <th>Price</th>
                    <!-- Add more columns as needed -->
                </tr>
                <?php while ($row = mysqli_fetch_assoc($groundsResult)) { ?>
                    <tr>
                        <td><?php echo $row['ground_id']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td><?php echo $row['ground_name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <!-- Add more columns as needed -->
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No grounds listed by this admin.</p>
        <?php } ?>

        <a href="admin_info.php" class="back-btn">Back to Admin Profile</a>
    </div>
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
