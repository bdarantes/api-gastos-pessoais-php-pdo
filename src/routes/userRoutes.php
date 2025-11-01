<?php

use App\controllers\UserController;
use App\config\Database;

$database = new Database();
$db = $database->connect();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if($uri === '/register' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $controller = new UserController(($db));
    $controller->register(($data));
    exit;
}