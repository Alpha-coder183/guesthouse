<?php
// Start session if you need to store messages
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

// Retrieve the password input from the form (assuming POST method)
$input_password = $_POST['password'];

// Prepare SQL statement to select the password from the admin table where id is 1
$sql = "SELECT password FROM admin WHERE id = 1";
$result = $conn->query($sql);

// Check if the query returns a result
if ($result->num_rows > 0) {
    // Fetch the password from the database
    $row = $result->fetch_assoc();
    $db_password = $row['password'];

    // Compare the input password with the password in the database
    if ($input_password == $db_password) {
        $sql = "SELECT * FROM room_booking ORDER BY id DESC";
        $result = $conn->query($sql);
        function formatRoomType($room_type) {
            switch ($room_type) {
                case 'guesthouse_non_ac_premium_room':
                    return 'Non-AC Premium Room';
                case 'guesthouse_non_ac_deluxe_room':
                    return 'Non-AC Deluxe Room';
                case 'guesthouse_ac_premium_room':
                    return 'AC Premium Room';
                case 'guesthouse_ac_deluxe_room':
                    return 'AC Deluxe Room';
                case 'guesthouse_ac_luxury_suite':
                    return 'AC Luxury Suite';
                default:
                    return $room_type; // In case the room type doesn't match, return it as is
            }
        }
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            overflow-y: auto;
            height: 100vh;
            width: 100%;
        }

        body::-webkit-scrollbar {
            width: 0;
        }

        body {
            -ms-overflow-style: none; 
            scrollbar-width: none;
        }

        .sticky-header {
            background-color: black;
            color: white;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .logo h1 {
            margin: 0;
        }

        .menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .menu li {
            display: inline;
            margin-left: 20px;
        }

        .menu button {
            background-color: transparent;
            border: 2px solid white; 
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        .menu button:hover {
            background-color: white;
            color: black;
        }

        /* Centering the login form */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 50px); /* Full height minus header height */
            text-align: center;
        }

        .login-form {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Fixed width for the form */
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-form button {
            background-color: #007BFF; /* Bootstrap primary color */
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .menu .login-button {
            background-color: #B0B0B0; /* Lighter gray shade */
            color: black; /* Change text color to black */
            border: 2px solid white; /* White border for Home button */
        }
        .menu .login-button:hover {
            background-color: white; /* Change to white background on hover */
            color: black; /* Keep text color black on hover */
        }
        .login-form button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            background-color: #fafafa;
        }
    </style>
</head>
<body>
<div class="sticky-header">
        <div class="header-content">
            <div class="logo"><h1>Elysian Escapes</h1></div>
        </div>
</div>
<h2>Room Booking Records</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<thead><tr><th>Username</th><th>Room Type</th><th>Check-in Date</th><th>Check-out Date</th><th>Approval Status</th></tr></thead>";
    echo "<tbody>";

    // Fetch and display each record
    while ($row = $result->fetch_assoc()) {
        $checkin_date = date('d/m/Y', strtotime($row['date_start']));
        $checkout_date = date('d/m/Y', strtotime($row['date_end']));
        $room_type_formatted = formatRoomType($row['room_type']);
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $room_type_formatted . "</td>";
        echo "<td>" . $checkin_date . "</td>";
        echo "<td>" . $checkout_date . "</td>";
        if ($row['approved'] == 1){
            ?>
            <td>
            <?php
            echo "Approved";
            ?>
            </td>
            <?php
        }
        else{
        echo "<td>";
        ?>
        <form method="POST" action="approval.php">
            <input type="hidden" name="id" value="<?php echo $row['id']?>">
            <input type="hidden" name="password" value="<?php echo $input_password?>">
            <button type="submit">Approve</button>
        </form>
        <?php
        echo"</td>";
        echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}?>

</body>
</html>
<?php    // Perform any action for successful password verification
    } else {
        echo "Incorrect password!";
        // Perform any action for incorrect password
    }
} else {
    echo "No admin record found!";
}
$conn->close();
?>