<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="aboutj.css">
</head>
<body>
    <div class="sidebar">
        <div><a href="adminhome.php" title="Home"><img src="homeicon1.png" class="button" alt="Home" style="margin-top: 50px;"></a></div>
        <div><a href="route.php" title="Routes"><img src="railwayicon.jpg" class="button" alt="Route"></a></div>
        <div><a href="train.php" title="Trains"><img src="trainicon.jpg" class="button" alt="Train"></a></div>
        <div><a href="contacts.php" title="Messages"><img src="messageicon.jpg" class="button" alt="Messages"></a></div>
        <div><a href="notification.php" title="Notifications"><img src="notificationicon.jpg" class="button" alt="Notification"></a></div>
    </div>

    <div class="content">
        <div class="box">
            <h2>Routes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Route_ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Arrival</th>
			            <th>Departure</th>
                        <th>Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "connection.php";

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // SQL query to fetch routes
                        $sql1 = "SELECT route_id, from_station, to_station, arrival_time, departure_time, fee FROM routes";
                        $result = $conn->query($sql1);

                        // Initialize an empty string to hold the HTML
                        $output = "";

                    if ($result->num_rows > 0) {
                        // Fetch each row using mysqli_fetch_array
                        while ($row = mysqli_fetch_array($result)) {
                            $output .= "<tr>";
                            $output .= "<td>" . $row['route_id'] . "</td>";
                            $output .= "<td>" . $row['from_station'] . "</td>";
                            $output .= "<td>" . $row['to_station'] . "</td>";
                            $output .= "<td>" . $row['arrival_time'] . "</td>";
                            $output .= "<td>" . $row['departure_time'] . "</td>";
                            $output .= "<td>" . $row['fee'] . "</td>";
                            $output .= "</tr>";
                        }
                    } else {
                        $output = "<tr><td colspan='6'>No routes found</td></tr>";
                    }

                    echo $output;  // Output the generated HTML
                }
                ?>
                </tbody>
            </table>
            <a href="route.php" class="view-button">VIEW</a>
        </div>

        <div class="box">
            <h2>Trains</h2>
            <table>
                <thead>
                    <tr>
                        <th>Train_ID</th>
                        <th>Train Type</th>
                        <th>1st class Seats</th>
                        <th>2nd Class Seats</th>
                        <th>Economy Class Seats</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include "connection.php";

                // SQL query to fetch train details
                $sql2 = "SELECT train_id, train_type, total_seats_first_class, total_seats_second_class, total_seats_economy_class FROM trains";
                $result = $conn->query($sql2);

                // Initialize an empty string to hold the HTML
                $output = "";

                if ($result->num_rows > 0) {
                    // Fetch each row using mysqli_fetch_array
                    while ($row = mysqli_fetch_array($result)) {
                        $output .= "<tr>";
                        $output .= "<td>" . $row['train_id'] . "</td>";
                        $output .= "<td>" . $row['train_type'] . "</td>";
                        $output .= "<td>" . $row['total_seats_first_class'] . "</td>";
                        $output .= "<td>" . $row['total_seats_second_class'] . "</td>";
                        $output .= "<td>" . $row['total_seats_economy_class'] . "</td>";
                        $output .= "</tr>";
                    }
                } else {
                    $output = "<tr><td colspan='5'>No trains found</td></tr>";
                }

                echo $output;  // Output the generated HTML
            ?>
                </tbody>
            </table>
            <a href="train.php" class="view-button">VIEW</a>
        </div>

        <div class="box">
            <h2>Messages</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include "connection.php";

                // SQL query to fetch train details
                $sql2 = "SELECT fullname, email, contactnumber, subject, message, created_at FROM contacts";
                $result = $conn->query($sql2);

                // Initialize an empty string to hold the HTML
                $output = "";

                if ($result->num_rows > 0) {
                    // Fetch each row using mysqli_fetch_array
                    while ($row = mysqli_fetch_array($result)) {
                        $output .= "<tr>";
                        $output .= "<td>" . $row['fullname'] . "</td>";
                        $output .= "<td>" . $row['message'] . "</td>";
                        $output .= "<td>" . $row['created_at'] . "</td>";
                        $output .= "</tr>";
                    }
                } else {
                    $output = "<tr><td colspan='2'>No contacts found</td></tr>";
                }

                echo $output;  // Output the generated HTML
                ?>
                </tbody>
            </table>
            <a href="contacts.php" class="view-button">VIEW</a>
        </div>

        <div class="box">
            <h2>Notifications</h2>
            <table>
                <thead>
                    <tr>
                        <th>Train_ID</th>
                        <th>Notification</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include "connection.php";

                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                        // SQL query to fetch routes
                        $sql1 = "SELECT train_id, notification FROM notifications";
                        $result = $conn->query($sql1);

                        // Initialize an empty string to hold the HTML
                        $output = "";

                    if ($result->num_rows > 0) {
                        // Fetch each row using mysqli_fetch_array
                        while ($row = mysqli_fetch_array($result)) {
                            $output .= "<tr>";
                            $output .= "<td>" . $row['train_id'] . "</td>";
                            $output .= "<td>" . $row['notification'] . "</td>";
                            $output .= "</tr>";
                        }
                    } else {
                        $output = "<tr><td colspan='2'>No routes found</td></tr>";
                    }

                    echo $output;  // Output the generated HTML
                }
                ?>
                </tbody>
            </table>
            <a href="notification.php" class="view-button">VIEW</a>
        </div>
    </div>
</body>
</html>
