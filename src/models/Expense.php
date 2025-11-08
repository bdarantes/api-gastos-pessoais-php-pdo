<?php

namespace App\models;

use PDO;

class Expense {
    private $conn;
    private $table = 'expenses';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($user_id, $description, $amount, $date) {
        $query = "INSERT INTO {$this->table} (user_id, description, amount, date)
                  VALUES (:user_id, :description, :amount, :date)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':amount', $amount);
        $stmt->bindValue(':date', $date);

        if ($stmt->execute()) {
            return ["message" => "Despesa cadastrada com sucesso!"];
        }

        return ["error" => "Erro ao cadastrar despesa."];
    }

    public function readAll($user_id) {
        $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $description, $amount, $date) {
        $query = "UPDATE {$this->table}
                  SET description = :description, amount = :amount, date = :date
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':amount', $amount);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return ["message" => "Despesa atualizada com sucesso!"];
        }

        return ["error" => "Erro ao atualizar despesa."];
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return ["message" => "Despesa excluída com sucesso!"];
        }

        return ["error" => "Erro ao excluir despesa."];

    }
    

        

}