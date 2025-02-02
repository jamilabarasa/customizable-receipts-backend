<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id'], $data['username'])) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

$id = $data['id'];
$username = $data['username'];
$role = $data['role'] ?? null; 
$password = $data['password'];
try {
    $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password, role = IF(:role IS NOT NULL, :role, role) WHERE id = :id");
    $stmt->execute([':id' => $id, ':username' => $username,':password' => $password, ':role' => $role]);
    echo json_encode(["message" => "User updated successfully"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>
