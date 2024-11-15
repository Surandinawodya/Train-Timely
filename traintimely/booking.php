<?php
// Get train and route details from URL query string
$train_id = isset($_GET['train_id']) ? $_GET['train_id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $train_id = isset($_GET['train_id']) ? $_GET['train_id'] : '';
    $route_id = isset($_GET['route_id']) ? $_GET['route_id'] : '';
    $from_station = isset($_GET['from_station']) ? $_GET['from_station'] : '';
    $to_station = isset($_GET['to_station']) ? $_GET['to_station'] : '';
    $arrival_time = isset($_GET['arrival_time']) ? $_GET['arrival_time'] : '';
    $departure_time = isset($_GET['departure_time']) ? $_GET['departure_time'] : '';
    $fee = isset($_GET['fee']) ? $_GET['fee'] : '';
}
?>

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Ticket Booking</title>
    <link rel="stylesheet" href="headfoot.css"> <!-- Existing CSS file for header and footer -->
    <link rel="stylesheet" href="booking.css"> <!-- New CSS file for booking page styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body style="background-image: url(bookingwp.jpg); background-repeat: no-repeat; background-size: cover;">
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

    <main>
        <div class="booking-container">
            <div class="booking-form-container">
                <h2>Book Your Train Ticket</h2>
                <form id="bookingForm" action="booking.php" method="POST">
                    <div class="form-group">
                        <label for="train_id">Train ID:</label>
                        <input type="text" id="train_id" name="train_id" value="<?php echo $train_id; ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="journey_date">Date of Journey:</label>
                        <input type="date" id="journey_date" name="journey_date" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Passenger Name:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Phone Number:</label>
                        <input type="tel" id="contact" name="contact" required>
                    </div>

                    <div class="form-group">
                        <label for="class">Class:</label>
                        <select id="class" name="class" required>
                            <option value="Economy">Economy</option>
                            <option value="2nd Class">2nd Class</option>
                            <option value="1st Class">1st Class</option>
                        </select><br>
                    </div>
                    <div class="form-group">
                        <button type="submit">Book Ticket</button>
                    </div>
                    <?php
                        // Include your database connection file
                        include 'connection.php';

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Retrieve and sanitize form data
                            $train_id = mysqli_real_escape_string($conn, $_POST['train_id']);
                            $journey_date = mysqli_real_escape_string($conn, $_POST['journey_date']);
                            $class = mysqli_real_escape_string($conn, $_POST['class']);
                            $username = mysqli_real_escape_string($conn, $_POST['username']);
                            $email = mysqli_real_escape_string($conn, $_POST['email']);
                            $contact = mysqli_real_escape_string($conn, $_POST['contact']);
                            
                            // SQL query to insert the booking data into the table
                            $sql = "INSERT INTO bookings (train_id, user_id, journey_date, class, username, email, contact)
                                    VALUES ('$train_id', '$user_id', '$journey_date', '$class', '$username', '$email', '$contact')";

                            // Execute the query
                            if ($conn->query($sql) === TRUE) {
                                echo "Booking successfully saved!";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }

                            // Close the database connection
                            $conn->close();
                        }
                        ?>
                </form>
            </div>
        </div>
       
    </main>
    

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
