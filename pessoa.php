<?php

class Pessoa {  
    // Define a classe Pessoa

    private $conexao; // Armazena a conexão com o banco de dados
    private $nome_tabela = "pessoas"; // Nome da tabela usada no banco

    public $id;     // ID da pessoa 
    public $nome;   // Nome da pessoa 
    public $idade;  // Idade da pessoa 

    public function __construct($db) {
        // Construtor que recebe a conexão com o banco
        $this->conexao = $db;  
    }

    public function criar() {
        // Método para inserir uma nova pessoa no banco

        $query = "INSERT INTO " . $this->nome_tabela . " (nome, idade) VALUES (:nome, :idade)"; 
        // SQL para inserir nome e idade na tabela

        $stmt = $this->conexao->prepare($query); 
        // Prepara a query SQL para execução segura (evita SQL Injection)

        $this->nome = htmlspecialchars(strip_tags($this->nome)); 
        $this->idade = htmlspecialchars(strip_tags($this->idade));
        // Remove tags e caracteres especiais do nome e idade por segurança

        $stmt->bindParam(":nome", $this->nome); 
        $stmt->bindParam(":idade", $this->idade);
        // Liga os parâmetros da query com os valores das propriedades

        if ($stmt->execute()) { 
            // Executa a query e verifica se deu certo
            return true;
        }

        return false;
        // Retorna false se a inserção falhar
    }

    public function ler() {
        // Método para buscar todas as pessoas no banco

        $query = "SELECT id, nome, idade FROM " . $this->nome_tabela . " ORDER BY id ASC";
        // SQL que seleciona todos os registros da tabela pessoa ordenados por ID

        $stmt = $this->conexao->prepare($query); 
        // Prepara a query para execução

        $stmt->execute(); 
        // Executa a query

        return $stmt; 
        // Retorna o resultado da consulta (PDOStatement)
    }

    public function altera_idade($id, $novaIdade) {
        // Método para atualizar a idade de uma pessoa pelo ID

        $query = "UPDATE " . $this->nome_tabela . " SET idade = :idade WHERE id = :id";
        // SQL que atualiza a idade onde o id for igual ao informado

        $stmt = $this->conexao->prepare($query);
        // Prepara a query para execução

        $stmt->bindParam(':idade', $novaIdade);
        $stmt->bindParam(':id', $id);
        // Liga os parâmetros da query com os valores informados

        return $stmt->execute();
        // Executa a query e retorna true ou false
    }

    public function buscarPorId($id) {
        // Método para buscar uma pessoa pelo ID

        $query = "SELECT * FROM pessoa WHERE id = :id";
        // SQL que busca todos os campos da pessoa com o ID correspondente

        $stmt = $this->conexao->prepare($query);
        // Prepara a query

        $stmt->bindParam(':id', $id);
        // Liga o ID passado como parâmetro

        $stmt->execute();
        // Executa a consulta

        return $stmt->fetch(PDO::FETCH_ASSOC);
        // Retorna os dados da pessoa como um array associativo
    }

    public function excluir() {
        $query = "DELETE FROM " . $this->nome_tabela . " WHERE id = :id";
        $stmt = $this->conexao->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
?>
