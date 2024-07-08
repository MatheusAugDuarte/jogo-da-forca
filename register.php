<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $word = $_POST['word'];
    if ($word) {
        try {
            $db = new PDO('sqlite:../hangman.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $db->prepare('INSERT INTO words (word) VALUES (:word)');
            $stmt->bindParam(':word', $word);
            $stmt->execute();

            echo "Word saved successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Word is required!";
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Word</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Register a New Word</h1>
    <form action="../php/register.php" method="post">
        <input type="text" name="word" required>
        <button type="submit">Save Word</button>
    </form>
    <br>
    <button onclick="window.location.href='../index.html'">Go to Main Page</button>
    <button onclick="window.location.href='start_game.html'">Start New Game</button>
</body>
</html>
