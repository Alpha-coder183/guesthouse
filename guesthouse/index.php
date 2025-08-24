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
    </style>
</head>
<body>

    <div class="sticky-header">
        <div class="header-content">
            <div class="logo"><h1>Elysian Escapes</h1></div>
            <ul class="menu">
                <li><button onclick="location.href='index.php'" class="login-button">Login</button></li>
                <li><button onclick="location.href='signup.php'">Sign Up</button></li>
            </ul>
        </div>
    </div>

    <div class="login-container">
        <form class="login-form" action="home.php" method="POST">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
