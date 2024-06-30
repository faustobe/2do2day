<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $completed = isset($_POST['completed']) ? 1 : 0;

    $stmt = $pdo->prepare('UPDATE tasks SET completed = ? WHERE id = ?');
    $stmt->execute([$completed, $id]);
}

header('Location: index.php');
exit();
?>
