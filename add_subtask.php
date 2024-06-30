<?php
include 'config.php';

if (isset($_POST['task_id'], $_POST['description'], $_POST['expected_time'])) {
    $taskId = $_POST['task_id'];
    $description = $_POST['description'];
    $expectedTime = $_POST['expected_time'];

    $stmt = $conn->prepare("INSERT INTO subtasks (task_id, description, expected_time, spent_time) VALUES (?, ?, ?, 0)");
    $stmt->execute([$taskId, $description, $expectedTime]);

    header("Location: detail.php?id=$taskId");
    exit();
}
?>
