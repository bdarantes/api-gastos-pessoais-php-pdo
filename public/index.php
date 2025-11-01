<?php

require_once __DIR__ .'/../vendor/autoload.php';

use App\config\Database;

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/routes/userRoutes.php';

$db = new Database();
$conn = $db->connect();

echo json_encode(["status" => "Conexão com banco OK!"]);