<?php
session_start();

// Include the database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tour_travel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to retrieve user and booking details based on booking ID
function getBookingDetails($conn, $bookingID) {
    $sql = "SELECT users.username, bookings.* FROM bookings
            INNER JOIN users ON bookings.user_id = users.user_id
            WHERE bookings.booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Check if a booking ID is provided in the URL
if (isset($_GET['booking_id'])) {
    $bookingID = $_GET['booking_id'];

    // Retrieve booking details
    $bookingDetails = getBookingDetails($conn, $bookingID);

    if ($bookingDetails) {
        // Display user and booking details
        echo "Booking ID: " . $bookingDetails['booking_id'] . "<br>";
        echo "User: " . $bookingDetails['username'] . "<br>";
        echo "Package Name: " . $bookingDetails['package_name'] . "<br>";
        echo "Booking Date: " . $bookingDetails['booking_date'] . "<br>";
        echo "From: " . $bookingDetails['trip_start'] . "<br>";
        echo "To: " . $bookingDetails['trip_end'] . "<br>";
        echo "Seat Number: " . $bookingDetails['seat_number'] . "<br>";
    } else {
        echo "Booking not found.";
    }
} else {
    echo "Booking ID not provided.";
}

$conn->close();
?>
