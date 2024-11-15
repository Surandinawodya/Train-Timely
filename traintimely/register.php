<?php
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"]; 

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss",$full_name,$password,$email);
    if ( $stmt->execute()){
        echo "Success";
    } else {
        echo"Failed";
    }
}

mysqli_close($conn);
?>