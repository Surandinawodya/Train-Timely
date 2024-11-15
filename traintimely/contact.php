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
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Contacts.css">
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

    <main>
        <div class="contact1">
            <div class="contactform">
            <form action="contact.php" method="post">
                <h2>Get in Touch</h2>
                <div class="form-group">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Contact Number (Optional):</label>
                        <input type="text" id="phone" name="phone">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="5"  required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Attachment (Optional):</label>
                        <input type="file" id="attachment" name="attachment">
                    </div>
                        <div class="form-group">
                        <button type="submit">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php
    // Include the connection file
    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize form inputs
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Handle file upload
        $attachment = "";
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
            $uploadDir = "uploads/"; // Ensure this folder exists and is writable
            $fileName = basename($_FILES['attachment']['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $filePath)) {
                $attachment = $filePath; // Store the file path in the database
            } else {
                echo "Failed to upload the file.";
            }
        }

        // Insert data into the contacts table
        $sql = "INSERT INTO contacts (fullname, email, contactnumber, subject, message) 
                VALUES ('$name', '$email', '$phone', '$subject', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "Your message has been successfully submitted!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
    ?>

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