<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root"; // Adjust if needed
$password = ""; // Your database password
$dbname = "guesthouse"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$booking_id = $_POST['id']; // Get booking ID from POST request
$pass = $_POST['password'];
// Prepare and execute the update query to set approved to 1
$sql = "UPDATE room_booking SET approved = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id); // Bind the booking ID

// Execute the statement and check if successful
if ($stmt->execute()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to admin Page</title>
</head>
<body>
    <form id="postForm" method="POST" action="admin.php" >
        <input type="hidden" name="password" value="<?php echo $pass?>">
    </form>

    <script>
        // Automatically submit the form
        document.getElementById("postForm").submit();
    </script>
</body>
</html>


<?php
} else {
    // Set an error message in the session
    $_SESSION['message'] = "Error approving booking: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect back to the approval page or wherever necessary


?>
