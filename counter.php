<?php
// Load environment variables from .env file
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Database connection using environment variables
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? 'PageVisit';
$user = $_ENV['DB_USER'] ?? 'admin';
$pass = $_ENV['DB_PASS'] ?? '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Update the visit count
$pdo->exec("UPDATE page_visits SET visit_count = visit_count + 1 WHERE id = 1");

// Get the updated count
$stmt = $pdo->query("SELECT visit_count FROM page_visits WHERE id = 1");
$visit_count = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Counter</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .counter-box {
            background: white;
            padding: 40px 60px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .counter-box:hover {
            transform: translateY(-5px);
        }
        h1 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 600;
        }
        .counter-value {
            font-size: 3.5rem;
            font-weight: 600;
            color: #3498db;
            margin: 20px 0;
        }
        p {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #95a5a6;
        }
    </style>
</head>
<body>

<div class="counter-box">
    <h1>Welcome to Our Site</h1>
    <p>This page has been visited</p>
    <div class="counter-value"><?= number_format($visit_count) ?></div>
    <p>times</p>
    <div class="footer">Last updated: <?= date('Y-m-d H:i:s') ?></div>
</div>

</body>
</html>