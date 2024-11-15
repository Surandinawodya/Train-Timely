<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT route_name, start_time, end_time, train_code FROM train_routes";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["route_name"]. "</td><td>" . $row["start_time"]. "</td><td>" . $row["end_time"]. "</td><td>" . $row["train_code"]. "</td></tr>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
