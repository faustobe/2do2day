<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subtaskId = $_POST['subtask_id'];
    $spentTime = $_POST['spent_time'];

    // Aggiorna il tempo dedicato alla sottoattività
    $stmt = $conn->prepare("UPDATE subtasks SET spent_time = spent_time + ? WHERE id = ?");
    $stmt->execute([$spentTime, $subtaskId]);

    // Recupera l'ID dell'attività principale per reindirizzare alla pagina di dettaglio corretta
    $taskStmt = $conn->prepare("SELECT task_id FROM subtasks WHERE id = ?");
    $taskStmt->execute([$subtaskId]);
    $task = $taskStmt->fetch(PDO::FETCH_ASSOC);

    header("Location: detail.php?id=" . $task['task_id']);
    exit;
}
?>
