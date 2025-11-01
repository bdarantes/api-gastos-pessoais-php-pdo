<?php

namespace App\controllers;

use App\models\User;

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($data) {
        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            http_response_code(400);
            echo json_encode((["error" => "Todos os campos são obrigatórios."]));
            return;
        }

        $user = new User($this->db);

        if($user->existsByEmail($data['email'])) {
            http_response_code(409);
            echo json_encode(["error" => "E-mail já cadastrado."]);
            return;

        }

        $user->nome = $data['nome'];
        $user->email = $data['email'];
        $user->senha = $data['senha'];

        if ($user->create() === true) {
            http_response_code(201);
            echo json_encode(["message" => "Usuário cadastrado com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao cadastrar usuário."]);
        }

    }
}