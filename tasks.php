<?php
header("Content-type: application/json");
require("db/db.php");

if($_SERVER["REQUEST_METHOD"] === "GET") {
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
    exit;


$title = trim($data["title"]);
$stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
$stmt->execute(["title" => $title]);

echo json_encode(["message" => "Task added successfully"]);
exit;
}

?>