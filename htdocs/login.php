<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] !== true) {
    // Redirect to a logged-in page or perform any other action
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tour_travel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginUsername = $_POST['login_username'];
    $loginPassword = $_POST['login_password'];

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE BINARY username=?");
    $stmt->bind_param("s", $loginUsername);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $storedPassword);
        $stmt->fetch();

        if ($loginPassword === $storedPassword) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $loginUsername;

            // Redirect to the logged-in page
            header("Location: login_success_redirect.html");
            exit();
        } else { // Inside the else block for invalid password
            $_SESSION['error_message'] = "Invalid password";
            
            exit();
        }
    } else { // Inside the else block for invalid username
        $_SESSION['error_message'] = "Invalid username";
       exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login - Travel Management System</title>
</head>
<body>
    <header>
        <h1>Online Tours and Travel Management</h1>
    </header>

    <div class="navbar">
        <a href="booking.php" class="active">Book now</a>
        <a href="registration.html">Register</a>
        <a href="login.php">Login</a>
        <a href="index1.html">Home</a>
    </div>

    <main>
        <section id="login-section">
            <form action="login.php" method="post" id="login-form">
                <h1>LOGIN</h1>

                <label for="login-username">Username:</label>
                <input type="text" id="login-username" name="login_username" required>

                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="login_password" required><br><br>

                <p>New User?, <a href="redirect_register.html">CLICK TO REGISTER</a></p>

                <button type="submit" name="login" id="login">Login</button>
            </form>
        </section>

        <?php if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])): ?>
            <script>
                alert("<?php echo $_SESSION['error_message']; ?>");
            </script>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </main>
</body>
</html>
