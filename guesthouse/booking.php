<?php
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
    <title>Booking</title>
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
        .menu .booking-button {
            background-color: #B0B0B0; /* Lighter gray shade */
            color: black; /* Change text color to black */
        }

        .menu .booking-button:hover {
            background-color: white; /* Change to white background on hover */
            color: black; /* Keep text color black on hover */
        }

        .menu button:hover {
            background-color: white; /* Change background on hover */
            color: black; /* Change text color on hover */
        }
        .room-options {
            display: flex;
            flex-direction: column; /* Arrange items in a column */
            margin: 20px;
        }
        .room-option {
            display: flex; /* Flexbox layout for image and text */
            border: 1px solid #ccc; /* Border around each room option */
            border-radius: 5px; /* Rounded corners */
            padding: 20px;
            background-color: #f9f9f9; /* Light gray background */
            margin: 10px 0; /* Margin between room options */
            align-items: center; /* Center align items vertically */
        }
        .room-option img {
            width: 150px; /* Fixed width for images */
            height: 100px; /* Fixed height for images */
            object-fit: cover; /* Cover image without distortion */
            margin-right: 20px; /* Space between image and text */
        }
        .book-room {
            display: inline-block;
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .book-room:hover {
            background-color: darkblue; /* Darker shade on hover */
        }
        .logo h1 {
            margin: 0;
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
                    <li><form action="home.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit">Home</button></form></li>
                    <li><form action="booking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit" class="booking-button">Booking</button></form></li>
                    <li><form action="mybooking.php" method="POST"><input type="hidden" name="username" value="<?php echo $user?>"><input type="hidden" name="password" value="<?php echo $pass?>"><button type="submit">My Bookings</button></form></li>
                </ul>
        </div>
    </header>
    <?php
    if (isset($_SESSION['message'])) {
        echo "<p style='color: green; text-align: center;'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']); // Clear the message after displaying it
        }
    ?>
    <div class="room-options">
        <div class="room-option">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhFhwGia8i27xqz-my5SGF0fqm9ptz1jdJDg&s" alt="Non-AC Premium Room">
            <div>
                <h2>Non-AC Premium Room</h2>
                <p>Price: ₹400 for 2 people</p>
                <form method="POST" action="room_booking.php">
                    <input type="hidden" name="room_type" value="guesthouse_non_ac_premium_room">
                    <input type="hidden" name="username" value="<?php echo $user?>">
                    <input type="hidden" name="password" value="<?php echo $pass?>">
                    <button type="submit" class="book-room">Book Room</button>
                </form>
            </div>
        </div>
        <div class="room-option">
            <img src="https://lh3.googleusercontent.com/proxy/ff0zmYylUuCFEV3luzqZIIChcrwcqNg9hSt0UPEC1k_PFh4u10F8YPcAU-eXRtgt1WH2UO_dut3l0MHjgTLkJr0CBwrY-gcY" alt="Non-AC Deluxe Room">
            <div>
                <h2>Non-AC Deluxe Room</h2>
                <p>Price: ₹600 for 5 people</p>
                <form method="POST" action="room_booking.php">
                    <input type="hidden" name="room_type" value="guesthouse_non_ac_deluxe_room">
                    <input type="hidden" name="username" value="<?php echo $user?>">
                    <input type="hidden" name="password" value="<?php echo $pass?>">
                    <button type="submit" class="book-room">Book Room</button>
                </form>
            </div>
        </div>
        <div class="room-option">
            <img src="https://imgcy.trivago.com/c_fill,d_dummy.jpeg,e_sharpen:60,f_auto,h_534,q_40,w_800/partner-images/39/08/00b2aa7b62b4b4be248b1cda0861a2bdbdac791670e1328ac03e4227aa8f.jpeg" alt="AC Premium Room">
            <div>
                <h2>AC Premium Room</h2>
                <p>Price: ₹500 for 2 people</p>
                <form method="POST" action="room_booking.php">
                    <input type="hidden" name="room_type" value="guesthouse_ac_premium_room">
                    <input type="hidden" name="username" value="<?php echo $user?>">
                    <input type="hidden" name="password" value="<?php echo $pass?>">
                    <button type="submit" class="book-room">Book Room</button>
                </form>
            </div>
        </div>
        <div class="room-option">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGQDfe-uQ7pRbuoP_FL2enIrK2obsZGUI2GEc7cuQz4wY6Ol4ey-UmzjdKIzADY9nkp7k&usqp=CAU" alt="AC Deluxe Room">
            <div>
                <h2>AC Deluxe Room</h2>
                <p>Price: ₹800 for 5 people</p>
                <form method="POST" action="room_booking.php">
                    <input type="hidden" name="room_type" value="guesthouse_ac_deluxe_room">
                    <input type="hidden" name="username" value="<?php echo $user?>">
                    <input type="hidden" name="password" value="<?php echo $pass?>">
                    <button type="submit" class="book-room">Book Room</button>
                </form>
            </div>
        </div>
        <div class="room-option">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkShFgDtvDMgJhFQWwybGLEaBmSlBh2ttXYA&s" alt="AC Luxury Suite">
            <div>
                <h2>AC Luxury Suite</h2>
                <p>Price: ₹1200 for 10 people</p>
                <form method="POST" action="room_booking.php">
                    <input type="hidden" name="room_type" value="guesthouse_ac_luxury_suite">
                    <input type="hidden" name="username" value="<?php echo $user?>">
                    <input type="hidden" name="password" value="<?php echo $pass?>">
                    <button type="submit" class="book-room">Book Room</button>
                </form>
            </div>
        </div>
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