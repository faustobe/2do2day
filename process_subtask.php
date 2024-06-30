<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskId = $_POST['task_id'];
    $description = $_POST['description'];
    $expectedTime = $_POST['expected_time'];

    $stmt = $conn->prepare("INSERT INTO subtasks (task_id, description, expected_time) VALUES (?, ?, ?)");
    $stmt->execute([$taskId, $description, $expectedTime]);

    header("Location: detail.php?id=$taskId");
    exit;
}
?>
