<?php

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["admin_email"];
    $password = $_POST["admin_password"];

    $sql = "SELECT * FROM admins WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "Error: " . mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            echo "PW: ".$row["password"];
            echo "U PW: ".$password;

            if ($password == $row["password"]) {

                // User logged in successfully, start a session and redirect
                session_start();
                $_SESSION["admin_id"] = $row["admin_id"]; // Assuming you have an ID column in the users table
                header("Location: adminhome.php");
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User not found.";
        }

        mysqli_stmt_close($stmt);
    }
}

// Echo "connected" to confirm the connection
echo "Connected";

mysqli_close($conn);