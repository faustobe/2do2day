<?php
include 'config.php';

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Recupera i dettagli dell'attività
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$taskId]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        die("Attività non trovata.");
    }

    // Recupera le sottoattività
    $subtaskStmt = $conn->prepare("SELECT * FROM subtasks WHERE task_id = ?");
    $subtaskStmt->execute([$taskId]);
    $subtasks = $subtaskStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dettagli Attività</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Dettagli Attività</h1>
    <h2><?php echo htmlspecialchars($task['description']); ?></h2>
    <p>Data di creazione: <?php echo $task['created_at']; ?></p>
    <p>Tempo totale previsto: <?php echo array_sum(array_column($subtasks, 'expected_time')); ?> ore</p>
    <p>Tempo totale speso: <?php echo array_sum(array_column($subtasks, 'spent_time')); ?> ore</p>
    <p>Tempo rimanente: <?php echo array_sum(array_column($subtasks, 'expected_time')) - array_sum(array_column($subtasks, 'spent_time')); ?> ore</p>

    <h3>Sottoattività</h3>
    <ul>
        <?php foreach ($subtasks as $subtask): ?>
            <li>
                <?php echo htmlspecialchars($subtask['description']); ?> - 
                Tempo previsto: <?php echo $subtask['expected_time']; ?> ore - 
                Tempo speso: <?php echo $subtask['spent_time']; ?> ore
                <form action="update_subtask.php" method="post" style="display:inline;">
                    <input type="hidden" name="subtask_id" value="<?php echo $subtask['id']; ?>">
                    <input type="number" name="spent_time" placeholder="Aggiungi ore">
                    <button type="submit">Aggiungi Tempo</button>
                </form>
                <a href="delete_subtask.php?id=<?php echo $subtask['id']; ?>" onclick="return confirm('Sei sicuro di voler cancellare questa sottoattività?');">Cancella</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Aggiungi Sottoattività</h3>
    <form action="add_subtask.php" method="post">
        <input type="hidden" name="task_id" value="<?php echo $taskId; ?>">
        <input type="text" name="description" placeholder="Descrizione sottoattività" required>
        <input type="number" name="expected_time" placeholder="Tempo previsto (ore)" required>
        <button type="submit">Aggiungi Sottoattività</button>
    </form>

    <a href="index.php">Torna alla matrice</a>
</body>
</html>
