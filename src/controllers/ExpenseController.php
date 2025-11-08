<?php

namespace App\controllers;

use App\models\Expense;

class ExpenseController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleRequest() {
        header('Content-Type: application/json; charset=utf-8');
        $method = $_SERVER['REQUEST_METHOD'];
        $data = json_decode(file_get_contents('php://input'), true);

        $expense = new Expense($this->db);

        switch ($method) {
            case 'POST':
                if (!isset($data['user_id'], $data['description'], $data['amount'], $data['date'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Campos obrigatórios ausentes"]);
                    return;
                }

                echo json_encode($expense->create (
                    $data['user_id'], $data['description'], $data['amount'], $data['date']

                ));
                break;
            
            case 'GET':
                if (!isset($_GET['user_id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Informe o user_id"]);
                    return;
                }

                echo json_encode($expense->readAll($_GET['user_id']));
                break;

            case 'PUT':
                if (!isset($data['id'], $data['description'], $data['amount'], $data['date'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Campos obrigatórios ausentes"]);
                    return;
                }

                echo json_encode($expense->update(
                    $data['id'], $data['description'], $data['amount'], $data['date']
                ));
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $params);
                if(!isset($params['id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Informe o ID da despesa"]);
                    return;

                }

                echo json_encode($expense->delete($params['id']));
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método não permitido"]);
        }
    }
}