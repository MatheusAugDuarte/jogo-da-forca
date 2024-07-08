<?php
require 'Database.php';

$db = new Database(__DIR__ . '/../hangman.db');
$pdo = $db->getPDO();

$stmt = $pdo->query("SELECT word FROM words ORDER BY RANDOM() LIMIT 1");
$word = $stmt->fetchColumn();

echo json_encode(['word' => $word]);
?>
