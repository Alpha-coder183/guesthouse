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
    $_SESSION['username'] = $user;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking - Elysian Escapes</title>
    <style>
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
        .menu .room_booking-button {
            background-color: #B0B0B0; /* Lighter gray shade */
            color: black; /* Change text color to black */
        }

        .menu .room_booking-button:hover {
            background-color: white; /* Change to white background on hover */
            color: black; /* Keep text color black on hover */
        }

        .menu button:hover {
            background-color: white; /* Change background on hover */
            color: black; /* Change text color on hover */
        }


        .booking-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .booking-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .booking-form input[type="text"],
        .booking-form input[type="number"],
        .booking-form input[type="date"],
        .booking-form input[type="email"],
        .booking-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .booking-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .booking-form button:hover {
            background-color: #45a049;
        }

        /* Center alignment for the selected room message */
        .selected-room-message {
            text-align: center;
            margin: 20px 0;
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
                    <li><form action="booking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit" class="room_booking-button">Booking</button></form></li>
                    <li><form action="mybooking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit">My Bookings</button></form></li>
                </ul>
            </nav>
        </div>
    </header>

    <div style="padding: 20px;">
        <?php
        // Get the selected room type from POST request
        $selected_room = $_POST['room_type'] ?? '';

        // Display selected room message
        if ($selected_room == "guesthouse_non_ac_premium_room") {
            echo "<h2 class='selected-room-message'>You have selected: Non-AC Premium Room</h2>";
        } elseif ($selected_room == "guesthouse_non_ac_deluxe_room") {
            echo "<h2 class='selected-room-message'>You have selected: Non-AC Deluxe Room</h2>";
        } elseif ($selected_room == "guesthouse_ac_premium_room") {
            echo "<h2 class='selected-room-message'>You have selected: AC Premium Room</h2>";
        } elseif ($selected_room == "guesthouse_ac_deluxe_room") {
            echo "<h2 class='selected-room-message'>You have selected: AC Deluxe Room</h2>";
        } elseif ($selected_room == "guesthouse_ac_luxury_suite") {
            echo "<h2 class='selected-room-message'>You have selected: AC Luxury Suite</h2>";
        } else {
            echo "<h2 class='selected-room-message'>No room selected.</h2>";
        }
        ?>
        
        <form class="booking-form" action="confirm_booking.php" method="POST">
            <input type="hidden" name="room_type" value="<?php echo $selected_room; ?>">
    
            <label for="checkin">Check-in Date:</label>
            <input type="date" id="checkin" name="checkin" required>

            <label for="checkout">Check-out Date:</label>
            <input type="date" id="checkout" name="checkout" required>
            <input type="hidden" name="username" value="<?php echo $user?>">
            <input type="hidden" name="password" value="<?php echo $pass?>">
            <button type="submit">Request Booking</button>
        </form>
    </div>
</body>
</html>
<?php
} else {
    // User not found
    echo "Invalid username or password.";
}

// Close connection
$stmt->close();
$conn->close();
?>