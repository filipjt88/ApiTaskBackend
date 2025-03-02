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

// Deleted task
if($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($data["id"])) {
        echo json_encode(["error" => "Task ID is required!"]);
        exit;
    }
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->execute(["id" => $data["id"]]);
    echo json_encode(["message" => "Task deleted successfully"]);
    exit;
}

// Edited task
if($_SERVER("REQUEST_METHOD") === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if(!isset($data["id"]) || !isset($data["title"]) || !isset($data["completed"])) {
        echo json_encode(["error" => "ID, title, and completed status are required!"]);
        exit;
    }
    $stmt = $pdo->prepare("UPDATE tasks SET title = :title, completed = :completed WHERE id = :id");
    $stmt->execute([
        "id" => $data["id"],
        "title" => $data["title"],
        "completed" => $data["completed"]
    ]);
    echo json_encode(["message" => "Task updated successfully"]);
    exit;
}



?>