<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Attività cancellata con successo";
    } catch(PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}

$conn = null;

header('Location: index.php');
exit;
?>
