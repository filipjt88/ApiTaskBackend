<?php
header("Content-type: application/json");
require("db/db.php");

if($_SERVER["REQUEST_METHOD"] === "GET") {
    if(!$pdo) {
        die(json_encode(["error" => "Konekcija sa bazom nije uspela!"]));
    }
    $stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tasks);
    exit;
}

// Add new task
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($data["title"]) || empty(trim($data["title"]))) {
        echo json_encode(["error" => "Title is requared!"]);
        exit;
    }

$title = trim($data["title"]);
$stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
$stmt->execute(["title" => $title]);

echo json_encode(["message" => "Task added successfully"]);
exit;
}

?>