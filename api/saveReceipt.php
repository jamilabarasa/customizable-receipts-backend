<?php
header("Content-Type: application/json");

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");

header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['receiptNumber'], $data['branchName'], $data['storeAddress'], $data['total'], $data['items'])) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO receipts (receipt_number, branch_name, store_address, total, items,printed_by) 
        VALUES (:receipt_number, :branch_name, :store_address, :total, :items, :printed_by)
    ");
    $stmt->execute([
        ':receipt_number' => $data['receiptNumber'],
        ':branch_name' => $data['branchName'],
        ':store_address' => $data['storeAddress'],
        ':total' => $data['total'],
        ':items' => json_encode($data['items']),
        ':printed_by' => $data['printed_by']
    ]);

    echo json_encode(["message" => "Receipt saved successfully"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>
