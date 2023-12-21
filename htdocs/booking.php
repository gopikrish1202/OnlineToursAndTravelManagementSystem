<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if the booking form is submitted
if (isset($_POST['book'])) {
    // Redirect to the booking confirmation page
    header("Location: booking_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #da70d6;
            color: black;
            text-align: left;
            padding: 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar {
            display: flex;
        }

        .navbar a {
            color: black;
            text-decoration: none;
            padding: 14px 16px;
            margin-right: 20px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        form {
            margin: 20px;
        }

        h1 {
            text-align: left;
        }
    </style>
</head>
<body>
    <header>
        <h1>Online Tours and Travel Management</h1>
        <input type="checkbox" id="menu-toggle">
        <div class="navbar">
            <a href="process.php?logout">Logout</a>
            <a href="booking.php" class="active">Book now</a>
            <a href="index1_loggedin.php">Home</a>
        </div>
    </header>

    <form action="process.php" method="post">
        <h1>Book your journey</h1>
        <label for="from-location">From:</label>
        <input type="text" id="from-location" name="from_location" placeholder="Enter your location" required><br><br>
        
        <label for="to-location">To:</label>
        <input type="text" id="to-location" name="to_location" placeholder="Enter destination" required><br><br>

        <label for="onward-journey">Onward Journey:</label>
        <input type="date" id="onward-journey" name="onward_journey" required><br><br>

        <label for="return-journey">Return Journey:</label>
        <input type="date" id="return-journey" name="return_journey" required><br><br>

        <button type="submit" name="book">Book Now</button>
    </form>

    <script>
        $(document).ready(function() {
            if (!<?php echo json_encode($_SESSION['isLoggedIn']); ?>) {
                alert('Please log in to make a booking.');
                window.location.href = 'login.php';
            }
        });
    </script>
</body>
</html>
