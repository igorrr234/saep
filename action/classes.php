<?php

include('database/conexao.php');

$db = new Database();

class Usuario
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar($nome, $email, $senha, $confSenha)
    {
        if ($senha == $confSenha) {

            $emailExistente = $this->verificacaoEmailExistente($email);
            if ($emailExistente) {
                print "<script>alert('Email já cadastrado')</script>";
                return false;
            }

            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nome_usuario, email_usuario, senha) VALUES (?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $senhaCriptografada);
            $result = $stmt->execute();

            return $result;
        } else {
            return false;
        }
    }

    private function verificacaoEmailExistente($email)
    {
        $sql = "SELECT COUNT(*) from usuario WHERE email_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    public function logar($email, $senha)
    {
        $sql = "SELECT * FROM usuario WHERE email_usuario =:email_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email_usuario', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $usuario['senha'])) {
                return true;
            }
        }
    }
}






class Crud
{
    private $conn;
    private $table_name = "turmas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($postValues)
    {
        $curso = $postValues['curso'];
        $descricao = $postValues['descricao'];
        $quantidade_alunos = $postValues['quantidade_alunos'];

        $query = "INSERT INTO " . $this->table_name . " (curso,descricao,quantidade_alunos) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $curso);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $quantidade_alunos);
        $rows = $this->read();
        if ($stmt->execute()) {
            print "<script>alert('Cadastrado com sucesso!')</script>";
            print "<script> location.href='?action=read'; </script>";
            return true;
        } else {
            return false;
        }
    }

    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update($postValues)
    {
        $id = $postValues['id'];
        $curso = $postValues['curso'];
        $descricao = $postValues['descricao'];
        $quantidade_alunos = $postValues['quantidade_alunos'];
    
        if (empty($id) || empty($curso) || empty($descricao) || empty($quantidade_alunos)) {
            return false;
        }
    
        $query = "UPDATE " . $this->table_name . " SET curso = ?, descricao = ?, quantidade_alunos = ? WHERE id = ?";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(1, $curso);
        $stmt->bindParam(2, $descricao);
        $stmt->bindParam(3, $quantidade_alunos);
        $stmt->bindParam(4, $id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "DELETE FROM  " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function search($term)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE curso LIKE ? OR descricao LIKE ? OR quantidade_alunos LIKE ?";
        $stmt = $this->conn->prepare($query);
        $term = "%" . $term . "%";
        $stmt->bindParam(1, $term);
        $stmt->bindParam(2, $term);
        $stmt->bindParam(3, $term);
        $stmt->execute();
        return $stmt;
    }

}