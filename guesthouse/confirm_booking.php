<?php
// Start session to store messages
session_start();

// Database connection parameters
$servername = "localhost"; // Adjust if needed
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "guesthouse"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$room_type = $_POST['room_type'] ?? '';
$date_start = $_POST['checkin'] ?? '';
$date_end = $_POST['checkout'] ?? '';
$user = $_POST['username'] ?? '';
$approved = 0; // Initial approval status
$pass = $_POST['password'] ?? '';

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO room_booking (username, room_type, date_start, date_end, approved) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $user, $room_type, $date_start, $date_end, $approved);

// Execute the statement
if ($stmt->execute()) {
    // Set a success message in session
    $_SESSION['message'] = "Your room has been requested successfully!";
    // Prepare data to send to booking.php
    $postData = [
        'room_type' => $room_type,
        'checkin' => $date_start,
        'checkout' => $date_end,
        'username' => $user,
    ];
} else {
    // Set an error message in session
    $_SESSION['message'] = "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to Booking Page</title>
</head>
<body>
    <form id="postForm" action="booking.php" method="POST">
        <input type="hidden" name="username" value="<?php echo $user?>">
        <input type="hidden" name="password" value="<?php echo $pass?>">
    </form>

    <script>
        // Automatically submit the form
        document.getElementById("postForm").submit();
    </script>
</body>
</html>
