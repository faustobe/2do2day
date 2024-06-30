<?php
include 'config.php';

if (isset($_GET['id'])) {
    $subtaskId = $_GET['id'];

    // Recupera l'id dell'attività
    $stmt = $conn->prepare("SELECT task_id FROM subtasks WHERE id = ?");
    $stmt->execute([$subtaskId]);
    $taskId = $stmt->fetchColumn();

    // Elimina la sottoattività
    $stmt = $conn->prepare("DELETE FROM subtasks WHERE id = ?");
    $stmt->execute([$subtaskId]);

    header("Location: detail.php?id=$taskId");
    exit();
}
?>
