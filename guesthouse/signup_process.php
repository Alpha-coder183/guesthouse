<?php
// Replace with your own database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guesthouse";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input from form
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];
$confirm_pass = $_POST['confirm_password'];

$sql_check = "SELECT * FROM members WHERE username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $user);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// Check if the user exists
if ($result_check->num_rows > 0) {
    echo "User exist try to log in";
    exit();
}
// Check if passwords match
if ($pass !== $confirm_pass) {
    echo "Passwords do not match.";
    exit();
}

// Prepare and execute the insert query
$sql = "INSERT INTO members(username, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user, $email, $pass);

if ($stmt->execute()) {
    // Successful signup, redirect to index.php
    header("Location: index.php");
    exit(); // Make sure to exit after redirection
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
