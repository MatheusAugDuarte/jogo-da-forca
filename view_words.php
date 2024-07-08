<?php
// Database connection
try {
    $db = new PDO('sqlite:hangman.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Query to select words and their statistics
$query = "SELECT word, times_played, times_correct FROM words";
$stmt = $db->prepare($query);
$stmt->execute();
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the words and statistics
echo "<h2>Words and Statistics</h2>";
echo "<table border='1'>";
echo "<tr><th>Word</th><th>Times Played</th><th>Times Correct</th></tr>";
foreach ($words as $word) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($word['word']) . "</td>";
    echo "<td>" . $word['times_played'] . "</td>";
    echo "<td>" . $word['times_correct'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
