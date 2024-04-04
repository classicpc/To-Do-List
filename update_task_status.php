<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['taskId']) && isset($_POST['status'])) {
    include 'db_connection.php'; // Ensure this path is correct

    $taskId = $connection->real_escape_string($_POST['taskId']);
    $status = $connection->real_escape_string($_POST['status']) == 1 ? 1 : 0;

    $sql = "UPDATE tasks SET status = ? WHERE taskid = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $connection->errno . ") " . $connection->error;
        exit;
    }

    $stmt->bind_param("ii", $status, $taskId);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Task status updated successfully."]);
    } else {
        echo json_encode(["message" => "Error updating task status."]);
    }

    $stmt->close();
    $connection->close();
} else {
    echo json_encode(["message" => "Invalid request"]);
}
?>
