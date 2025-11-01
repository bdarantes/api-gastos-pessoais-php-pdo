<?php

namespace App\models;

use PDO;
use PDOException;

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $nome;
    public $email;
    public $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO {$this->table} (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $this->conn->prepare($query);

            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);

            $stmt->bindValue(':nome', $this->nome);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':senha', $this->senha);

            if($stmt->execute()) {
                return true;
            }
                return false;

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }

    }

    public function existsByEmail($email) {
        $query = "SELECT id FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->rowCount () >0;
    }
    
}