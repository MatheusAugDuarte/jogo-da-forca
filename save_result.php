<?php
require 'Database.php';

$data = json_decode(file_get_contents('php://input'), true);
$word = $data['word'];
$result = $data['result'];

$db = new Database(__DIR__ . '/../hangman.db');
$pdo = $db->getPDO();

if ($result === 'won') {
    $pdo->exec("UPDATE words SET times_played = times_played + 1, times_won = times_won + 1 WHERE word = '$word'");
} else {
    $pdo->exec("UPDATE words SET times_played = times_played + 1, times_lost = times_lost + 1 WHERE word = '$word'");
}
?>
