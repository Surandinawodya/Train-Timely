<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Contacts</title>
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
        <h1>Contact Messages</h1>
        <table id="notification-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Subject</th>
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
                        $output .= "<td>" . $row['email'] . "</td>";
                        $output .= "<td>" . $row['contactnumber'] . "</td>";
                        $output .= "<td>" . $row['subject'] . "</td>";
                        $output .= "<td>" . $row['message'] . "</td>";
                        $output .= "<td>" . $row['created_at'] . "</td>";
                        $output .= "</tr>";
                    }
                } else {
                    $output = "<tr><td colspan='6'>No contacts found</td></tr>";
                }

                echo $output;  // Output the generated HTML
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>