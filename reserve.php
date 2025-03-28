<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $table_id = $_POST['table_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    // Check if table is already reserved
    $check_sql = "SELECT is_reserved FROM tables WHERE id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $table_id);
    $stmt->execute();
    $stmt->bind_result($is_reserved);
    $stmt->fetch();
    $stmt->close();

    if ($is_reserved) {
        echo json_encode(["status" => "error", "message" => "Table is already reserved!"]);
        exit;
    }

    // Insert reservation
    $sql = "INSERT INTO reservations (name, email, phone, table_id, date, time, guests) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $email, $phone, $table_id, $date, $time, $guests);
    
    if ($stmt->execute()) {
        // Mark table as reserved
        $update_sql = "UPDATE tables SET is_reserved = TRUE WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("s", $table_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo json_encode(["status" => "success", "message" => "Reservation Confirmed!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to reserve the table!"]);
    }

    $stmt->close();
}
$conn->close();
?>
