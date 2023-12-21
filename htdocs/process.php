<?php
session_start();
ob_start(); // Start output buffering to capture output

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tour_travel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration logic
if (isset($_POST['register'])) {
    $username = $_POST['register_username'];
    $password = $_POST['register_password'];
    $email = $_POST['register_email'];
    $address = $_POST['register_address'];

    // For simplicity, we are not hashing the password in this example
    // In a production environment, it's crucial to hash passwords before storing them
    // Use password_hash() for hashing and password_verify() for verification

    $stmt = $conn->prepare("INSERT INTO users (username, password, email, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $address);

    if ($stmt->execute()) {
        // Registration successful, redirect to register_success_redirect.html
        header("Location: register_success_redirect.html");
        exit(); // Ensure no further code is executed after redirection
    } else {
        error_log("Error executing SQL query: " . $stmt->error);
        echo "Registration failed. Please try again later.";
    }

    $stmt->close();
}

// Login logic
if (isset($_POST['login'])) {
    $loginUsername = $_POST['login_username'];
    $loginPassword = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE BINARY username=?");
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $storedPassword);
        $stmt->fetch();

        if (password_verify($loginPassword, $storedPassword)) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $loginUsername;

            session_regenerate_id(true); // Regenerate session ID to prevent session fixation attacks

            header("Location: login_success_redirect.html");
            exit();
        } else {
            $errorMessage = "Invalid password";
        }
    } else {
        $errorMessage = "Invalid username";
    }

    $stmt->close();
}

// Display error message if any
if (isset($errorMessage)) {
    echo $errorMessage;
    exit();  // Exit here to avoid further output before header
}

// Logout logic
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    // Regenerate session ID to prevent session fixation attacks

    header("Location: logout_redirect.html");
    exit(); // Ensure no further code is executed after redirection
}

// Booking logic
if (isset($_SESSION['user_id']) && isset($_POST['book'])) {
    // Retrieve booking details from the form
    $fromLocation = $_POST['from_location'];
    $toLocation = $_POST['to_location'];
    $onwardJourney = $_POST['onward_journey'];
    $returnJourney = $_POST['return_journey'];

    // Generate a random seat number
    $seatNumber = generateRandomSeat();

    // Perform any booking operations here (e.g., save to database)

    // Display booking confirmation
    $confirmationMessage = "Booking Confirmation:\n\nFrom: $fromLocation\nTo: $toLocation\nOnward Journey: $onwardJourney\nReturn Journey: $returnJourney\nSeat Number: $seatNumber";

    // Insert booking details into the database
    $bookingID = generateRandomID();
    $userID = $_SESSION['user_id'];
    $packageName = $fromLocation . ' - ' . $toLocation; // Replace with the actual package name
    date_default_timezone_set('Asia/Kolkata');
    $bookingDate = date("Y-m-d"); // Current date
    

    $stmt = $conn->prepare("INSERT INTO bookings (booking_id, user_id, package_name, booking_date, trip_start, trip_end, seat_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $bookingID, $userID, $packageName, $bookingDate, $onwardJourney, $returnJourney, $seatNumber);
    $stmt->execute();

    // Display user and booking details
    echo "User ID: $userID<br>";
    echo "From: $fromLocation<br>";
    echo "To: $toLocation<br>";
    echo "Onward Journey: $onwardJourney<br>";
    echo "Return Journey: $returnJourney<br>";
    echo "Booking Date: $bookingDate<br>";
    echo "Seat Number: $seatNumber<br>";
    $packageName = $fromLocation . ' - ' . $toLocation;
    // Redirect to booking confirmation page
    header("Location: booking_confirmation.php");
    exit();
} elseif (!isset($_SESSION['user_id'])) {
    echo "Error: Invalid user";
}

$conn->close();

// Flush output buffer
ob_end_flush();

// Function to generate a random seat number (e.g., A1, B3, C5)
function generateRandomSeat() {
    $alphabet = range('A', 'Z');
    $randomLetter = $alphabet[array_rand($alphabet)];
    $randomNumber = rand(1, 10); // You can adjust the range as needed
    return $randomLetter . $randomNumber;
}

// Function to generate a random alphanumeric ID
function generateRandomID() {
    $prefix = "BID";
    $randomNumbers = mt_rand(1000, 9999); // You can adjust the range as needed
    return $prefix . $randomNumbers;
}
?>
