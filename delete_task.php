<?php
include 'config.php';

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Elimina le sottoattività prima di eliminare l'attività
    $stmt = $conn->prepare("DELETE FROM subtasks WHERE task_id = ?");
    $stmt->execute([$taskId]);

    // Elimina l'attività
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$taskId]);

    header("Location: index.php");
    exit();
}
?>
