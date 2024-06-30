<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST["description"];
    $quadrant = $_POST["quadrant"];

    try {
        $sql = "INSERT INTO tasks (description, quadrant, status) VALUES (:description, :quadrant, 0)";
        $stmt = $conn->prepare($sql); 
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':quadrant', $quadrant);
        $stmt->execute();

        echo "Nuova attività aggiunta con successo";
    } catch(PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}

$conn = null;
header('Location: index.php');
exit;
?>
