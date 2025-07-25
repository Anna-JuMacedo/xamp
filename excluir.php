<?php
require_once 'conexao.php';
require_once 'classebase.php';

if (isset($_GET['nome']) && isset($_GET['tabela'])) {
    $nome = $_GET['nome'];
    $tabela = $_GET['tabela'];

    $obj = new ClasseBase($conexao, $tabela);
    $obj->nome = $nome;

    if ($obj->excluir()) {
        echo "Registro <strong>$nome</strong> excluído com sucesso.";
    } else {
        echo "Erro ao excluir o registro. Verifique se a tabela é permitida ou se o nome existe.";
    }
} else {
    echo "Parâmetros inválidos.";
}
?>
