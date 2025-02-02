<?php
header("Content-Type: application/json");

// Allow requests from all origins
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");

header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['username'], $data['password'])) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

$username = $data['username'];
$password = $data['password'];

try {
  
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password AND is_active = 1");
   
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        
        echo json_encode([
            "message" => "Login successful",
            "userId" => $user['id'],
            "username" => $user['username'],
            "role" => $user['role']
        ]);
    } else {
      
        http_response_code(401); 
        echo json_encode(["message" => "Invalid username, password, or user not active"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>

