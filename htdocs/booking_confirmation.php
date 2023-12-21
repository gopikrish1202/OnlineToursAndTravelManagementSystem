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

// Function to generate a random seat number (e.g., A1, B3, C5)
function generateRandomSeat() {
    $alphabet = range('A', 'Z');
    $randomLetter = $alphabet[array_rand($alphabet)];
    $randomNumber = rand(1, 10); // You can adjust the range as needed
    return $randomLetter . $randomNumber;
}

// Check if the booking form is submitted
if (isset($_POST['book'])) {
    // Retrieve booking details from the form
    $fromLocation = $_POST['from_location'];
    $toLocation = $_POST['to_location'];
    $onwardJourney = $_POST['onward_journey'];
    $returnJourney = $_POST['return_journey'];

    // Generate a random seat number
    $seatNumber = generateRandomSeat();

    // Insert booking details into the database
    $bookingID = generateRandomID();
    $userID = $_SESSION['user_id'];
    $packageName = "Your Package Name"; // Replace with the actual package name
    $bookingDate = date("Y-m-d"); // Current date

    $stmt = $conn->prepare("INSERT INTO bookings (booking_id, user_id, package_name, booking_date, trip_start, trip_end, seat_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $bookingID, $userID, $packageName, $bookingDate, $onwardJourney, $returnJourney, $seatNumber);
    $stmt->execute();

    // Display booking confirmation
    echo "Booking Confirmation:<br>";
    echo "From: $fromLocation<br>";
    echo "To: $toLocation<br>";
    echo "Onward Journey: $onwardJourney<br>";
    echo "Return Journey: $returnJourney<br>";
    echo "Seat Number: $seatNumber<br>";
    echo "Booking Date: $bookingDate<br>";
} else {
    // Redirect to the booking page if the form is not submitted
    header("Location: booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Online Tours and Travel Management</h1>
        <div class="navbar">
            <a href="index1.html">Home</a>
        </div>
    </header>

    <main>
        <section>
            <h1>Booking Confirmation</h1>
            <p>
            <?php
            // Retrieve and display user and booking details from the database
            $sql = "SELECT * FROM bookings WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "Booking ID: " . $row['booking_id'] . "<br>";
                    echo "Package Name: " . $row['package_name'] . "<br>";
                    echo "Booking Date: " . $row['booking_date'] . "<br>";
                    echo "From: " . $row['trip_start'] . "<br>";
                    echo "To: " . $row['trip_end'] . "<br>";
                    echo "Seat Number: " . $row['seat_number'] . "<br>";
                    echo "<hr>";
                }
            } else {
                echo "No bookings found.";
            }

            $stmt->close();
            ?>
            </p>
        </section>
    </main>
</body>
</html>
