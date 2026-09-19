<?php

header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../vendor/autoload.php';

use CodeCore\Engine\CasinoCore;

$inputData = json_decode(file_get_contents("php://input"), true);

if (!isset($inputData['action'], $inputData['user_id'], $inputData['amount'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid payload structure"]);
    exit;
}

$engine = new CasinoCore("mysql:host=localhost;dbname=goldsvet_core");

switch ($inputData['action']) {
    case 'spin':
        $result = $engine->processBet(
            (int)$inputData['user_id'], 
            (float)$inputData['amount'], 
            $inputData['provider'] ?? 'PragmaticPlay'
        );
        echo json_encode($result);
        break;
        
    default:
        http_response_code(404);
        echo json_encode(["error" => "Action not supported"]);
        break;
}
