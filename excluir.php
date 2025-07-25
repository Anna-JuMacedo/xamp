<?php
require_once 'conexao.php';

class ClasseBase {
    protected $conexao;
    protected $nome_tabela;
    public $id;

    public function __construct($conexao, $nome_tabela) {
        $this->conexao = $conexao;
        $this->nome_tabela = $nome_tabela;
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
