<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Add Train</title>
	<link rel="stylesheet" href="headerfooternew123.css">

    <script>
        function updateTrainIdPrefix() {
            const trainType = document.getElementById('trainType').value;
            const trainIdField = document.getElementById('trainId');

            // Set the prefix based on train type
            let prefix = '';
            if (trainType == 'Express') {
                prefix = 'E';
            } else if (trainType == 'Intercity') {
                prefix = 'I';
            } else if (trainType == 'Slow') {
                prefix = 'S';
            }

            // Update the placeholder or value with the prefix
            trainIdField.placeholder = prefix + ' - Train ID';
            trainIdField.value = prefix; // Optional: Set initial value if needed
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <div><a href="adminhome.php" title="Home"><img src="homeicon1.png" class="button" alt="Notification" style="margin-top: 50px;"></a></div>
        <div><a href="route.php" title="Routes"><img src="railwayicon.jpg" class="button" alt="Route"></a></div>
        <div><a href="train.php" title="Trains"><img src="trainicon.jpg" class="button" alt="Train"></a></div>
        <div><a href="contacts.php" title="Messages"><img src="messageicon.jpg" class="button" alt="Messages"></a></div>
        <div><a href="notification.php" title="Notifications"><img src="notificationicon.jpg" class="button" alt="Notification"></a></div>
    </div>

    <div class="container">
        <h1>Add Train</h1>
        <form id="bookingForm" action="train.php" method="post">
            <!-- Train Type Selection -->
            <div class="form-group">
                <label for="trainType">Train Type:</label>
                <select id="trainType" name="trainType" onchange="updateTrainIdPrefix()" required>
                    <option value="Express">Express</option>
                    <option value="Intercity">Intercity</option>
                    <option value="Slow">Slow</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trainId">Train ID:</label>
                <input type="text" id="trainId" name="trainId" required >
            </div>
			<div class="form-group">
                <label for="trainId">Route ID:</label>
                <select id="routeId" name="routeId" required>
                    <?php
                    // Include your database connection
                    include 'connection.php';

                    // Fetch route IDs from the routes table
                    $sql = "SELECT route_id FROM routes";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['route_id'] . "'>" . $row['route_id'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No routes available</option>";
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </select>
            </div>
            <!-- Separate input fields for each class type -->
            <div class="form-group">
                <label for="numSeats1st">Number of Seats (1st Class):</label>
                <input type="number" id="numSeats1st" name="numSeats1st" required>
            </div>
            <div class="form-group">
                <label for="numSeats2nd">Number of Seats (2nd Class):</label>
                <input type="number" id="numSeats2nd" name="numSeats2nd" required>
            </div>
            <div class="form-group">
                <label for="numSeats3rd">Number of Seats (Economy Class):</label>
                <input type="number" id="numSeats3rd" name="numSeats3rd" required>
            </div>
            <button type="submit">Add Train</button>
        </form>
        <div id="bookingList"></div>
    </div>
    <div class="container">
        <h1>Added Trains</h1>
        <table id="added-trains-table">
            <thead>
                <tr>
                    <th>Train ID</th>
                    <th>Train Type</th>
                    <th>Max 1st Class</th>
                    <th>Max 2nd Class</th>
                    <th>Max 3rd Class</th>
                </tr>
            </thead>
            <tbody>
            <?php
                include "connection.php";

                // SQL query to fetch train details
                $sql2 = "SELECT train_id, route_id, train_type, total_seats_first_class, total_seats_second_class, total_seats_economy_class FROM trains";
                $result = $conn->query($sql2);

                // Initialize an empty string to hold the HTML
                $output = "";

                if ($result->num_rows > 0) {
                    // Fetch each row using mysqli_fetch_array
                    while ($row = mysqli_fetch_array($result)) {
                        $output .= "<tr>";
                        $output .= "<td>" . $row['train_id'] . "</td>";
                        $output .= "<td>" . $row['route_id'] . "</td>";
                        $output .= "<td>" . $row['train_type'] . "</td>";
                        $output .= "<td>" . $row['total_seats_first_class'] . "</td>";
                        $output .= "<td>" . $row['total_seats_second_class'] . "</td>";
                        $output .= "<td>" . $row['total_seats_economy_class'] . "</td>";
                        $output .= "</tr>";
                    }
                } else {
                    $output = "<tr><td colspan='6'>No trains found</td></tr>";
                }

                echo $output;  // Output the generated HTML
            ?>
            </tbody>
        </table>
    </div>
    <?php
    include "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $trainType = $_POST['trainType'];
        $trainId = $_POST['trainId'];
        $routeid = $_POST['routeId'];
        $numSeats1st = $_POST['numSeats1st'];
        $numSeats2nd = $_POST['numSeats2nd'];
        $numSeats3rd = $_POST['numSeats3rd'];
    
        // Prepare SQL query to insert data
        $sql = "INSERT INTO trains (train_id, route_id, train_type, total_seats_first_class, total_seats_second_class, total_seats_economy_class) 
                VALUES ('$trainId', '$routeid', '$trainType', $numSeats1st, $numSeats2nd, $numSeats3rd)";
        
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "New train added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>
