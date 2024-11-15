<?php
include "connection.php";
session_start();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    // Fetch train IDs related to the logged-in user
    $sql = "SELECT DISTINCT train_id FROM bookings WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $train_ids = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $train_ids[] = $row['train_id'];
    }

    mysqli_stmt_close($stmt);

    // Fetch notifications for the user's train IDs
    if (!empty($train_ids)) {
        $placeholders = implode(',', array_fill(0, count($train_ids), '?'));
        $sql = "SELECT train_id, notification FROM notifications WHERE train_id IN ($placeholders)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, str_repeat('i', count($train_ids)), ...$train_ids);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $notifications = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $notifications[] = $row;
        }
        echo json_encode($notifications);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode([]);
    }
    mysqli_close($conn);
} else {
    echo json_encode([]);
}
?>
