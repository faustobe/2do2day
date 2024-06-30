<?php
include 'config.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    try {
        $sql = "UPDATE tasks SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Stato dell'attività aggiornato con successo";
    } catch(PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}

$conn = null;

header('Location: index.php');
exit;
?>
