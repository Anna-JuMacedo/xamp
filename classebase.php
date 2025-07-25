<?php
require_once 'conexao.php';

class ClasseBase {
    protected $conexao;
    protected $nome_tabela;
    public $nome;

    public function __construct($conexao, $nome_tabela) {
        $this->conexao = $conexao;
        $this->nome_tabela = $nome_tabela;
    }

    public function excluir() {
        $tabelasPermitidas = ['pessoas', 'produtos'];
        if (!in_array($this->nome_tabela, $tabelasPermitidas)) {
            return false;
        }

        $query = "DELETE FROM " . $this->nome_tabela . " WHERE nome = :nome";
        $stmt = $this->conexao->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $stmt->bindParam(':nome', $this->nome);

        return $stmt->execute();
    }
}
?>
