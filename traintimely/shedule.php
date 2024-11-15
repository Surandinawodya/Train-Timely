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
    <style>
        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            font-size: 2.5em;
            background-color: white;
            border-radius: 10px
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        /* Form Styles */
        form {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        form label {
            font-weight: bold;
            margin-right: 10px;
        }

        form select, form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        form button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1em;
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:nth-child(odd) {
            background-color: #fff;
        }

        button {
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-color: #007BFF;
            border-radius: 5px;
        }

        button:hover {
            cursor: pointer;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Train Schedule</title>
    <link rel="stylesheet" href="shedule.css"> <!-- CSS file for the schedule page -->
    <link rel="stylesheet" href="headfoot.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

</head>
<body>
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
        <?php
            include 'connection.php'; // Include your database connection

            // Fetch unique from_station and to_station for the dropdown
            $stations_sql = "SELECT DISTINCT from_station, to_station FROM routes";
            $stations_result = $conn->query($stations_sql);

            // Initialize variables for storing search criteria
            $from_station = isset($_POST['from_station']) ? $_POST['from_station'] : '';
            $to_station = isset($_POST['to_station']) ? $_POST['to_station'] : '';

            // Build SQL query to fetch train and route details
            $sql = "SELECT t.train_id, t.train_type, t.total_seats_first_class, t.total_seats_second_class, t.total_seats_economy_class, 
                    r.route_id, r.from_station, r.to_station, r.arrival_time, r.departure_time, r.fee
                    FROM trains t 
                    INNER JOIN routes r ON t.route_id = r.route_id";

            // Modify SQL query based on search criteria
            if ($from_station != '' && $to_station != '') {
                $sql .= " WHERE r.from_station = '$from_station' AND r.to_station = '$to_station'";
            }

            $result = $conn->query($sql);
            ?>

            <h1>Train Schedule</h1>

            <!-- Search form with dropdown for route filtering -->
            <form method="POST" action="">
                <label for="from_station">From Station:</label>
                <select id="from_station" name="from_station">
                    <option value="">Select Station</option>
                    <?php
                    if ($stations_result->num_rows > 0) {
                        while ($row = $stations_result->fetch_assoc()) {
                            $selected = ($from_station == $row['from_station']) ? 'selected' : '';
                            echo "<option value='{$row['from_station']}' $selected>{$row['from_station']}</option>";
                        }
                    }
                    ?>
                </select>

                <label for="to_station">To Station:</label>
                <select id="to_station" name="to_station">
                    <option value="">Select Station</option>
                    <?php
                    if ($stations_result->num_rows > 0) {
                        // Reset pointer and fetch again for to_station
                        $stations_result->data_seek(0);
                        while ($row = $stations_result->fetch_assoc()) {
                            $selected = ($to_station == $row['to_station']) ? 'selected' : '';
                            echo "<option value='{$row['to_station']}' $selected>{$row['to_station']}</option>";
                        }
                    }
                    ?>
                </select>

                <button type="submit">Search</button>
            </form>

            <!-- Table to display train and route details -->
            <table border="1" id="myTable">
                <thead>
                    <tr>
                        <th>Train ID</th>
                        <th>Train Type</th>
                        <th>Max 1st Class Seats</th>
                        <th>Max 2nd Class Seats</th>
                        <th>Max Economy Seats</th>
                        <th>Route ID</th>
                        <th>From Station</th>
                        <th>To Station</th>
                        <th>Arrival Time</th>
                        <th>Departure Time</th>
                        <th>Fee</th>
                        <th>Book</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['train_id']}</td>
                                    <td>{$row['train_type']}</td>
                                    <td>{$row['total_seats_first_class']}</td>
                                    <td>{$row['total_seats_second_class']}</td>
                                    <td>{$row['total_seats_economy_class']}</td>
                                    <td>{$row['route_id']}</td>
                                    <td>{$row['from_station']}</td>
                                    <td>{$row['to_station']}</td>
                                    <td>{$row['arrival_time']}</td>
                                    <td>{$row['departure_time']}</td>
                                    <td>{$row['fee']}</td>
                                    <td><a href='booking.php?train_id=" . $row['train_id'] . "&route_id=" . $row['route_id'] . "&from_station=" . $row['from_station'] . "&to_station=" . $row['to_station'] . "&arrival_time=" . $row['arrival_time'] . "&departure_time=" . $row['departure_time'] . "&fee=" . $row['fee'] . "' class='book-btn'><button>Book</button></a></td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No results found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
    </main>

    <script src="shedule.js"></script> <!-- Link to the JavaScript file -->
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


