<?php

namespace App\models;

use PDO;

class Auth {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $senha) {
        $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return ["error" => "Usuário não encontrado"];
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($senha, $user['senha'])) {
            return ["error" => "Senha incorreta"];
        }

        unset($user['senha']);

        return [
            "message" => "Login realizado com sucesso!",
            "user" => $user
        ];


    }


   
}