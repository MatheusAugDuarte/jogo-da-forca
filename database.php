<?php
class Database {
    private $pdo;

    public function __construct($file) {
        $dsn = "sqlite:" . $file;
        try {
            $this->pdo = new PDO($dsn);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}

// Initialize database and create tables if not exist
$db = new Database(__DIR__ . '/../hangman.db');
$pdo = $db->getPDO();
$pdo->exec("CREATE TABLE IF NOT EXISTS words (
    id INTEGER PRIMARY KEY,
    word TEXT NOT NULL,
    times_played INTEGER DEFAULT 0,
    times_won INTEGER DEFAULT 0,
    times_lost INTEGER DEFAULT 0
)");
?>
