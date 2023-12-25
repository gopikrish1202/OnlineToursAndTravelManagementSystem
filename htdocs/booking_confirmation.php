<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Include the database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tour_travel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if query parameters are present
if (isset($_GET['booking_id'])) {
    $bookingID = $_GET['booking_id'];

    // Retrieve booking details from the database
    $stmt = $conn->prepare("SELECT from_location, to_location, trip_start, trip_end, seat_number, booking_date FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("s", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $bookingData = $result->fetch_assoc();

      // Display booking details
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Booking Confirmation</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";
echo "<body>";
echo "<header>";
echo "<h1>Online Tours and Travel Management</h1>";
echo "<div class='navbar'>";
echo "<a href='index1.html'>Home</a>";
echo "<a href='process.php?logout'>Logout</a>";
echo "</div>";
echo "</header>";
echo "<main>";
echo "<section>";
echo "<h1>Booking Confirmation</h1>";

// Check for NULL values and display accordingly
echo "<p>From: " . ($bookingData['from_location'] !== null ? $bookingData['from_location'] : 'Not available') . "</p>";
echo "<p>To: " . ($bookingData['to_location'] !== null ? $bookingData['to_location'] : 'Not available') . "</p>";
echo "<p>Onward Journey: " . $bookingData['trip_start'] . "</p>";
echo "<p>Return Journey: " . $bookingData['trip_end'] . "</p>";
echo "<p>Seat Number: " . $bookingData['seat_number'] . "</p>";
echo "<p>Booking Date: " . $bookingData['booking_date'] . "</p>";
echo "</section>";
echo "</main>";
echo "</body>";
echo "</html>";

    } else {
        echo "Booking not found.";
    }

    $stmt->close();
} else {
    echo "Invalid URL parameters.";
}

$conn->close();
?>
