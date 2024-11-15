<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Route</title>
    <link rel="stylesheet" href="addroutenew1.css">
    </style>
</head>
<body>
    <div class="sidebar">
        <div><a href="adminhome.php" title="Home"><img src="homeicon1.png" class="button" alt="Home" style="margin-top: 50px;"></a></div>
        <div><a href="route.php" title="Routes"><img src="railwayicon.jpg" class="button" alt="Route"></a></div>
        <div><a href="train.php" title="Trains"><img src="trainicon.jpg" class="button" alt="Train"></a></div>
        <div><a href="contacts.php" title="Messages"><img src="messageicon.jpg" class="button" alt="Messages"></a></div>
        <div><a href="notification.php" title="Notifications"><img src="notificationicon.jpg" class="button" alt="Notification"></a></div>
    </div>

    <div class="container">
        <h1>Add New Route</h1>
        <form id="routeForm" action="route.php" method="POST">
            <div class="form-group destination-container">
                <label for="destination" style="flex-basis: 100%;">Location:</label>
                <input type="text" id="routeFrom" name="routeFrom" placeholder="From" class="destination-input" required>
                <span class="separator">-</span>
                <input type="text" id="routeTo" name="routeTo" placeholder="To" class="destination-input" required>
            </div>
            <div class="form-group destination-container">
                <label for="destination" style="flex-basis: 100%;">Time:</label>
                <input type="time" id="routeArrival" name="routeArrival" placeholder="Arrival" class="destination-input" required>
                <span class="separator">-</span>
                <input type="time" id="routeDeparture" name="routeDeparture" placeholder="Departure" class="destination-input" required>
            </div>
            <div class="form-group">
                <label for="routeFee">Fee:</label>
                <input type="number" id="routeFee" name="routeFee" required>
            </div>
            <button type="submit">Add Route</button>
        </form>
        <div id="routeList"></div>
    </div>
    <div class="container">
        <h1>Added Routes</h1>
        <table id="added-trains-table">
            <thead>
                <tr>
                    <th>Route ID</th>
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
    </div>
    <?php
    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $routeFrom = $_POST['routeFrom'];
        $routeTo = $_POST['routeTo'];
        $routeArrival = $_POST['routeArrival'];
        $routeDeparture = $_POST['routeDeparture'];
        $routeFee = $_POST['routeFee'];
    
        // SQL query to insert data into routes table
        $sql = "INSERT INTO routes (from_station, to_station, arrival_time, departure_time, fee) 
                VALUES ('$routeFrom', '$routeTo', '$routeArrival', '$routeDeparture', $routeFee)";
    
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "New route added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
