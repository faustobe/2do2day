<?php
$servername = "localhost";
$username = "bapu"; 
$password = "manny&cal"; 
$dbname = "eisenhower_matrix";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die(); // Interrompi l'esecuzione dello script in caso di errore
}
?>
