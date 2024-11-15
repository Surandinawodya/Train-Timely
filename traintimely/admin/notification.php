<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Add Notification</title>
	<link rel="stylesheet" href="headerfooternew123.css">
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
        <h1>Add Notification</h1>
        <form id="notificationForm" action="notification.php" method="post">
            <div class="form-group">
                <label for="trainId">Train ID:</label>
                <input type="text" id="trainId" name="trainId" required >
            </div>
			<div class="form-group">
                <label for="trainId">Notification</label>
                <input type="text" id="notification" name="notification" required >
            </div>
            <button type="submit">Add Notification</button>
        </form>
    </div>
    <div class="container">
        <h1>Sent Notifications</h1>
        <table id="notification-table">
            <thead>
                <tr>
                    <th>Train ID</th>
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
    </div>
    <?php
        include "connection.php";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $trainId = $_POST['trainId'];
            $notification = $_POST['notification'];
        
            // Prepare SQL query to insert data
            $sql = "INSERT INTO notifications (train_id, notification) 
                    VALUES ('$trainId', '$notification')";
            
            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo "New notification added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    
        // Close the connection
        $conn->close();
    ?>
    <script src="script.js"></script>
</body>
</html>