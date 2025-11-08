<?php

require_once __DIR__ .'/../vendor/autoload.php';

use App\config\Database;


header('Content-Type: application/json; charset=utf-8');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);




$db = new Database();
$conn = $db->connect();

switch ($uri) {
    case '/':
        echo json_encode(["status" => "API PHP funcionando e conectada ao banco"]);
        break;

    case '/register':
        require_once __DIR__ . '/../src/routes/userRoutes.php';
        break;

    case '/login':
        require __DIR__ . '/../src/routes/login.php';
        break;

    case '/expenses':
        require __DIR__ . '/../src/routes/expenses.php';
        break;


    default:
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada"]);
        break;

}