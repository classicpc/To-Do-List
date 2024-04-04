<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['taskId'])) {
    include 'db_connection.php'; // Ensure this path is correct

    $taskId = $connection->real_escape_string($_POST['taskId']);

    $sql = "DELETE FROM tasks WHERE taskid = ?";
    $stmt = $connection->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $connection->errno . ") " . $connection->error;
        exit;
    }

    $stmt->bind_param("i", $taskId);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Task deleted successfully."]);
    } else {
        echo json_encode(["message" => "Error deleting task."]);
    }

    $stmt->close();
    $connection->close();
} else {
    echo json_encode(["message" => "Invalid request"]);
}
?>
