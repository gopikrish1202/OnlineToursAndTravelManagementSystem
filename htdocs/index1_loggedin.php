<?php
session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    // Redirect to the error login page
    header("Location: error_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Tours and Travel Management</title>
    <style>
        body {
            font-family: cursive;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image: url("https://png.pngtree.com/background/20230324/original/pngtree-tourist-bus-cartoon-illustration-background-picture-image_2164866.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin-left: 20px;
        }

        header {
            background-color: #da70d6;
            color: black !important;
            color: #fff;
            text-align: left;
            padding: 1em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: cursive;
        }

        .profile-section {
            display: flex;
            align-items: center;
        }

        .profile-image {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .user-name {
            font-weight: bold;
        }

        .navbar {
            overflow: hidden;
            background-color: #da70d6;
            display: flex;
            justify-content: flex-end;
            font-family: cursive;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 14px 16px;
            color: black !important;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        main {
            padding: 2em;
        }

        #booking-section {
            width: 100%;
            padding: 20px;
            background-color: transparent;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            margin-left: 20px;
        }

        #bookingForm {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            margin: 20px 0;
        }

        .marquee-container {
            margin-left: 20px; /* Adjust margin to move marquee to the left */
        }

        .marquee {
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
            animation: marquee 20s linear infinite;
            font-family: cursive;
            
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
              
            }

            100% {
                transform: translateX(-100%);
               
            }
        }
       
        button {
            background-color: #007BFF;
            color: #fff;
            padding: 0.5em;
            margin-top: 1em;
            cursor: pointer;
            border: none;
            border-radius: 80px;
            font-size: xx-large;
            width: fit-content;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
            border-radius: 30px;
        }

        footer {
            text-align: center;
            padding: 1em;
            background-color: #da70d6;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }





        border: 3px solid black;
  border-radius: 5px;
  height: 100px;
  overflow: hidden;


#scroll-text {
  height: 100%;
  text-align: center;
  
  /* animation properties */
  -moz-transform: translateY(100%);
  -webkit-transform: translateY(100%);
  transform: translateY(100%);
  
  -moz-animation: my-animation 5s linear infinite;
  -webkit-animation: my-animation 5s linear infinite;
  animation: my-animation 5s linear infinite;
}

/* for Firefox */
@-moz-keyframes my-animation {
  from { -moz-transform: translateY(100%); }
  to { -moz-transform: translateY(-100%); }
}

/* for Chrome */
@-webkit-keyframes my-animation {
  from { -webkit-transform: translateY(100%); }
  to { -webkit-transform: translateY(-100%); }
}

@keyframes my-animation {
  from {
    -moz-transform: translateY(100%);
    -webkit-transform: translateY(100%);
    transform: translateY(100%);
  }
  to {
    -moz-transform: translateY(-100%);
    -webkit-transform: translateY(-100%);
    transform: translateY(-100%);
  }
}


        













    </style>
</head>
<body>
<header>
    <h1>Online Tours and Travel Management</h1>
    <div class="profile-section">
        <img src="https://cdn.icon-icons.com/icons2/2483/PNG/512/profile_menu_icon_149887.png" alt="Profile Image" class="profile-image">
        <span class="user-name"><?php echo $_SESSION['username']; ?></span>
    </div>
</header>

<div class="navbar">
    <a href="index1_loggedin.php">Home</a>
    <a href="booking.php" class="active">Book now</a>
    <a href="process.php?logout">Logout</a>
</div>

<main>
    <section id="booking-section">
        <form action="booking.php" method="post" id="bookingForm" style="font-family: cursive; background-color: #da70d6;">
            <h1> <strong>Welcome ,<br> <?php echo $_SESSION['username']; ?>!</strong></h1>
    
</div>
</div>
                <marquee class="css" behaviour="scroll" direction="up" scrollamount="2" loop="infinite" vspace="50px" bgcolor="#da70d6" style="font-family: cursive;">
               
                    Welcome to our Travel Management System!
                    Discover a world of seamless travel planning and booking.
                    From exotic destinations to curated experiences,
                    embark on unforgettable journeys.
                    Your adventure starts here,
                    where every detail is crafted for your wanderlust.
                    Explore, book, and create lasting memories with ease.
                    Join us in making every trip a remarkable experience.
                    From user-friendly interfaces to secure transactions,
                    our platform ensures a seamless travel experience.
                    Explore the world with confidence,
                    knowing every detail is meticulously managed
                    for your comfort and enjoyment.
                    Travel beyond boundaries with confidence, comfort, and personalized service.
                    Begin your journey today!
                </marquee>
            </div>
            <button type="submit" name="book">Book Now</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2023 Travel Management System</p>
</footer>
</body>
</html>
