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

// Get username and password from form
$user = $_POST['username'];
$pass = $_POST['password'];

// Prepare and execute the query
$sql = "SELECT * FROM members WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    // User found, start session and redirect to a welcome page
    session_start();
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
    $_SESSION['username'] = $user;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elysian Escapes - Home</title>
    <style>
        /* CSS for the sticky header */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden; /* Prevent horizontal scrolling */
            overflow-y: auto; /* Allows vertical scrolling */
            height: 100vh; /* Full height of the viewport */
            width: 100%; /* Full width */
        }

        /* Hide the scrollbar for vertical scrolling */
        body::-webkit-scrollbar {
            width: 0; /* Hide scrollbar */
        }
        
        body {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }

        .sticky-header {
            background-color: black;
            color: white;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000; /* Ensure it stays above other content */
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
            display: flex; /* Use flexbox to align buttons side by side */
        }

        .menu li {
            margin-left: 20px; /* Space between menu items */
        }

        .menu button {
            background-color: transparent;
            border: 2px solid white; /* Default button border color */
            color: white; /* Set default text color to white */
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Specific style for Home button */
        .menu .mybooking-button {
            background-color: #B0B0B0; /* Lighter gray shade */
            color: black; /* Change text color to black */
        }

        .menu .mybooking:hover {
            background-color: white; /* Change to white background on hover */
            color: black; /* Keep text color black on hover */
        }

        .menu button:hover {
            background-color: white; /* Change background on hover */
            color: black; /* Change text color on hover */
        }

        /* CSS for the body content */
        .hero-image {
            width: 100%; /* Image covers full width */
            height: 50vh; /* Image height is 50% of the viewport height */
            object-fit: cover; /* Maintain aspect ratio */
            margin: 0; /* Remove margin */
        }

        .details {
            text-align: left; /* Left align text */
            margin-top: 20px; /* Space above details */
            padding: 0 20px; /* Padding for left and right */
        }

        .details h2 {
            margin-bottom: 10px; /* Space below heading */
        }

        p {
            margin-bottom: 20px; /* Space below paragraph */
        }

        table {
            width: 100%; /* Table covers full width */
            border-collapse: collapse; /* Merge borders */
            margin-top: 20px; /* Space above the table */
        }

        th, td {
            border: 1px solid #ccc; /* Border for table cells */
            padding: 10px; /* Cell padding */
            text-align: left; /* Left align text in table */
        }

        th {
            background-color: #f2f2f2; /* Light gray background for header */
        }
    </style>
</head>
<body>
    <header class="sticky-header">
        <div class="header-content">
            <div class="logo">
                <h1>Elysian Escapes</h1>
            </div>
            <nav>
                <ul class="menu">
                    <li><form action="home.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit" >Home</button></form></li>
                    <li><form action="booking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit">Booking</button></form></li>
                    <li><form action="mybooking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit" class="mybooking-button">My Bookings</button></form></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php
        // Prepare and execute the query to fetch bookings for the specified user in decreasing order of ID
$sqll = "SELECT * FROM room_booking WHERE username = ? ORDER BY id DESC";
$stmtt = $conn->prepare($sqll);
$stmtt->bind_param("s", $user); // Bind the username
$stmtt->execute();
$resultt = $stmtt->get_result();

// Check if any bookings were found
if ($resultt->num_rows > 0) {
    // Display the bookings in a table
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Approval Status</th>
                </tr>
            </thead>
            <tbody>";

    // Output data of each row
    while ($roww = $resultt->fetch_assoc()) {
        $room_type_formatted = formatRoomType($roww['room_type']);
        echo "<tr>
                <td>" . $room_type_formatted . "</td>
                <td>" . date('d/m/Y', strtotime($roww['date_start'])) . "</td>
                <td>" . date('d/m/Y', strtotime($roww['date_end'])) . "</td>
                <td>" . ($roww['approved'] ? 'Approved' : 'Pending') . "</td>
              </tr>";
    }

    echo "</tbody></table>";
    $conn->close();
} else {
    echo "No bookings found for user" ;
}

// Close the statement and connection
$stmtt->close();
?>
    </body>
</html>
<?php
} else {
    // User not found
    echo "Invalid username or password.";
}

// Close connection
$stmt->close();

?>

