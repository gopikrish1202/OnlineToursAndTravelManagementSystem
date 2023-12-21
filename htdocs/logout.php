<?php
session_start();
if(session_destroy()){
    header("Location: logout_redirect.html");
    exit(); // Make sure to exit after header redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Logout - Travel Management System</title>
</head>
<body>
    <header>
        <h1>Online Tours and Travel Management</h1>
    </header>
    <form action="process.php" method="post">
        <input type="hidden" name="logout">
        <button type="submit">Logout</button>
    </form>
    <footer>
        <p>&copy; 2023 Travel Management System</p>
    </footer>
</body>
</html>
