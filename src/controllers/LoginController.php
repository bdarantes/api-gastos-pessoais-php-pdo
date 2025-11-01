<?php

namespace App\controllers;

use App\models\Auth;

class LoginController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function handleRequest() {
        header('Content-Type: application/json; charset=utf-8');
        $data = json_decode(file_get_contents('php://input'), true);

        if(!isset($data['email'], $data['senha'])) {
            http_response_code(400);
            echo json_encode(["error" => "Email e senha são obrigatórios"]);
            return;
        }

        $auth = new Auth($this->db);
        $result = $auth->login($data['email'], $data['senha']);

        if (isset($result['error'])) {
            http_response_code(401);
        }

        echo json_encode($result);
    }
}