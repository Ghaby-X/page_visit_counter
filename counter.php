<?php
$db   = "PageVisit";
$user = 'admin';
$pass = 'foaeio29034i9mdkf';
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
    <title>Visit Counter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
       .counter-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>

<div class="counter-box">
    <h1>Welcome to Our Site</h1>
    <p>This page has been visited <strong><?= $visit_count ?></strong> times.</p>
</div>

</body>
</html>
