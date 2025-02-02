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

if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["message" => "User ID is required"]);
    exit;
}

$id = $data['id'];

try {
    $stmt = $pdo->prepare("UPDATE users SET is_active = 1 WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo json_encode(["message" => "User activated successfully"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>
