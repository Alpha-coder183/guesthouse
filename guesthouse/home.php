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
        .menu .home-button {
            background-color: #B0B0B0; /* Lighter gray shade */
            color: black; /* Change text color to black */
        }

        .menu .home-button:hover {
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
                    <li><form action="home.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit" class="home-button">Home</button></form></li>
                    <li><form action="booking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit">Booking</button></form></li>
                    <li><form action="mybooking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit">My Bookings</button></form></li>
                </ul>
            </nav>
        </div>
    </header>

    <div>
        <img class="hero-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQU8GV0YnZ6dDo0NfXF2qaM0xOWbMkM1dCXPw&s" alt="Elysian Escapes">

        <div class="details">
            <h2>Welcome to Elysian Escapes</h2>
            <p>Your perfect getaway awaits! Located in the heart of India, we offer a variety of room options to cater to your needs.</p>
            <p>Contact us for booking inquiries:</p>
            <p>Address: 123 Imaginary Street, Some City, India</p>
            <p>Phone: +91 98765 43210</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Price (₹)</th>
                    <th>No. of People</th>
                    <th>No. of Rooms</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Non-AC Premium Room</td>
                    <td>400</td>
                    <td>2</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>Non-AC Deluxe Room</td>
                    <td>600</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>AC Premium Room</td>
                    <td>500</td>
                    <td>2</td>
                    <td>10</td>
                </tr>
                <tr>
                    <td>AC Deluxe Room</td>
                    <td>800</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>AC Luxury Suite</td>
                    <td>1200</td>
                    <td>10</td>
                    <td>2</td>
                </tr>
            </tbody>
        </table>
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

