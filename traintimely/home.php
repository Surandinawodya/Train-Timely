<?php
// Start session
session_start();

// Check if the user is logged in by verifying if 'user_id' is set in the session
if (isset($_SESSION["user_id"])) {
    // Retrieve user_id from the session
    $user_id = $_SESSION["user_id"];
    
    //echo "User ID: " . $user_id;

    // Use the user_id for queries, display, etc.
} else {
    // If the user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="headfoot.css">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <!--header-->
    <header>
        <div class="header-content">
            <div class="profile-icon">
                <a href="#"><img src="profimg.png"></a>
            </div>
            <div class="titlecont">
                <div class="title">
                    <h2>Train Timely</h2>
                </div>
            </div>
            <div class="rightspace">
                <div class="message-icon-container">
                    <img class="message-icon" src="download.png" >
                    <div class="notification-count">1</div>
                </div>
                 
            </div>
        </div>
        <div>
            <nav class="navigation">
                <a href="home.php"><button>Home</button></a>
                <a href="shedule.php"><button>Schedule</button></a>
                <a href="booking.php"><button>Booking</button></a>
                <a href="contact.php"><button>Contact</button></a>
            </nav>
        </div>
    </header>

    <maim>

        <!-- Video Background -->
        <video autoplay muted loop id="backgroundVideo">
            <source src="videos/trainVideo.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>

        <!--middle content-->
        <div class="middle-content">
            <div class="text-content">
                <div style="text-align: center;
                    margin-top:50px;">
                <h1 style="font-size: 50px;color: white;">Welcome to Sri Lanka Railways</h1>
                <p style="font-size: 18px;">Book your ticket now and embark on a seamless journey!</p>
                
            </div>
            <br><br>
            <a href="shedule.php"><button class="register-button">Book Now</button></a>
            </div>
        <?php
            include 'connection.php';

            $current_date = date('Y-m-d');

            // SQL query to get bookings where the journey date is in the future and the user_id matches the logged-in user
            $sql = "SELECT * FROM bookings WHERE user_id = ? AND journey_date >= ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $current_date);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>

        <div class="textcontent-2">
            <h2>Upcoming Schedules</h2>
            <?php if ($result->num_rows > 0): ?>
            <table style="color: black;">
                <thead>
                    <tr>
                        <th>Train ID</th>
                        <th>Journey Date</th>
                        <th>Class</th>
                        <th>Passenger Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['train_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['journey_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['class']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No upcoming bookings found.</p>
            <?php endif; ?>
        </div>

        <?php
        include 'connection.php';

        // SQL query to get all bookings for the logged-in user
        $sql = "SELECT * FROM bookings WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <div class="textcontent-2">
            <h2>Booking History</h2>
            <?php if ($result->num_rows > 0): ?>
            <table style="color: black;">
                <thead>
                    <tr>
                        <th>Train ID</th>
                        <th>Journey Date</th>
                        <th>Class</th>
                        <th>Passenger Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['train_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['journey_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['class']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact']);  
                    ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No bookings found.</p>
            <?php endif; ?>
        </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
            
        </div>
    </maim>
    

    <!--footer-->
    <footer>
        <div class="logo-container">
            <img src="logo.jpeg" alt="Your Company Logo">
            <p>Plan your train journeys with ease. Our website offers convenient scheduling, hassle-free booking, and reliable timetables. Find your perfect route and enjoy a stress-free travel experience.</p>
        </div>
        <div class="contact">
            <h2>Contact Us</h2>
            <p>Phone: +94 123 456 789</p>
            <p>Email: support@trainscheduling.com</p>
            <p>Address: 123 Main Street, Galle, Sri Lanka</p>
            <ul class="social-links">
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
        <div class="useful-links">
            <h2>Useful Links</h2>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="shedule.php">Scheduling</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="faq.html">FAQ</a></li>
            </ul>
        </div>
        <div class="legal">
            <h2>Legal</h2>
            <ul>
                <li><a href="terms-of-service.html">Terms of Service</a></li>
                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                <li><a href="cookie-policy.html">Cookie Policy</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>