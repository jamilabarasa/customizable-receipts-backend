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


$filters = [];
if (isset($_GET['branchName'])) {
    $filters['branchName'] = $_GET['branchName'];
}
if (isset($_GET['date'])) {
    $filters['date'] = $_GET['date'];
}
if (isset($_GET['cashierName'])) {
    $filters['cashierName'] = $_GET['cashierName'];
}


$query = "SELECT * FROM receipts";
if (count($filters) > 0) {
    $query .= " WHERE ";
    $conditions = [];
    foreach ($filters as $key => $value) {
        $conditions[] = "$key = :$key";
    }
    $query .= implode(" AND ", $conditions);
}

try {
    $stmt = $pdo->prepare($query);
    
    foreach ($filters as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->execute();

   
    $receipts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($receipts);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>
