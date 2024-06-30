<!DOCTYPE html>
<html>
<head>
    <title>Matrice di Eisenhower</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function validateForm(quadrant) {
            var description = document.getElementById('description' + quadrant).value;
            if (description.trim() === "") {
                alert("Il campo attività non può essere vuoto.");
                return false;
            }
            return true;
        }

        function confirmDelete(description) {
            return confirm("Sei sicuro di voler cancellare l'attività: " + description + "?");
        }
    </script>
</head>
<body>
    <h1>Matrice di Eisenhower</h1>

    <div class="container">
        <?php
        include 'config.php';
        $quadrants = [
            1 => 'Urgente e Importante',
            2 => 'Non Urgente ma Importante',
            3 => 'Urgente ma Non Importante',
            4 => 'Non Urgente e Non Importante'
        ];

        foreach ($quadrants as $quadrant => $title) {
            echo "<div class='quadrant'>";
            echo "<h2>$title</h2>";
            echo "<ul>";

            $stmt = $conn->query("SELECT * FROM tasks WHERE quadrant=$quadrant");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $statusClass = $row['status'] ? 'completed' : '';

                // Calcola i giorni trascorsi dalla creazione del task
                $createdAt = new DateTime($row['created_at']);
                $now = new DateTime();
                $interval = $createdAt->diff($now);
                $daysAgo = $interval->days;

                if ($daysAgo == 0) {
                    $daysAgoText = "oggi";
                } elseif ($daysAgo == 1) {
                    $daysAgoText = "ieri";
                } else {
                    $daysAgoText = "$daysAgo giorni fa";
                }

                // Calcola il tempo totale previsto e il tempo dedicato per l'attività
                $subtaskStmt = $conn->prepare("SELECT SUM(expected_time) AS total_expected_time, SUM(spent_time) AS total_spent_time FROM subtasks WHERE task_id = ?");
                $subtaskStmt->execute([$row['id']]);
                $subtaskData = $subtaskStmt->fetch(PDO::FETCH_ASSOC);

                $totalExpectedTime = $subtaskData['total_expected_time'] ?? 0;
                $totalSpentTime = $subtaskData['total_spent_time'] ?? 0;
                $timeRemaining = $totalExpectedTime - $totalSpentTime;
                $progressPercentage = $totalExpectedTime > 0 ? ($totalSpentTime / $totalExpectedTime) * 100 : 0;

                echo "<li class='$statusClass'>" . htmlspecialchars($row['description']) . " - " . $daysAgoText .
                     " - " . ($row['status'] ? 'Completato' : 'In corso') . 
                     " - Tempo previsto: $totalExpectedTime ore - Tempo rimanente: $timeRemaining ore" .
                     " <a href='delete.php?id=" . $row['id'] . "' onclick='return confirmDelete(\"" . htmlspecialchars($row['description']) . "\");'>Cancella</a>" .
                     " <a href='detail.php?id=" . $row['id'] . "'>Dettagli</a>";

                // Barra di progresso
                echo "<div class='progress-bar'>";
                echo "<div class='progress' style='width:" . $progressPercentage . "%;'></div>";
                echo "</div>";

                echo "</li>";
            }
            echo "</ul>";

            echo "<form action='process.php' method='post' onsubmit='return validateForm($quadrant);'>";
            echo "<input type='hidden' name='quadrant' value='$quadrant'>";
            echo "<input type='text' id='description$quadrant' name='description' placeholder='Nuova attività'>";
            echo "<button type='submit'>Aggiungi Attività</button>";
            echo "</form>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
