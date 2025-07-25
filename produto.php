<?php
class Produto {
    private $conexao;
    private $nome_tabela = "produtos";

    public $id;
    public $nome;
    public $preco;

    public function __construct($db) {
        $this->conexao = $db;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->nome_tabela . " (nome, preco) VALUES (:nome, :preco)";
        $stmt = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->preco = htmlspecialchars(strip_tags($this->preco));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":preco", $this->preco);

        return $stmt->execute();
    }

    public function ler() {
        $query = "SELECT id, nome, preco FROM " . $this->nome_tabela . " ORDER BY id ASC";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->conexao->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarProduto($id, $novoNome, $novoPreco) {
        $query = "UPDATE " . $this->nome_tabela . " SET nome = :nome, preco = :preco WHERE id = :id";
        $stmt = $this->conexao->prepare($query);

        $novoNome = htmlspecialchars(strip_tags($novoNome));
        $novoPreco = htmlspecialchars(strip_tags($novoPreco));

        $stmt->bindParam(":nome", $novoNome);
        $stmt->bindParam(":preco", $novoPreco);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
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
