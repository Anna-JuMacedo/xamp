<?php
require_once 'conexao.php';
require_once 'excluir.php';

if (isset($_GET['id']) && isset($_GET['tabela'])) {
    $id = $_GET['id'];
    $tabela = $_GET['tabela'];

    $obj = new ClasseBase($conexao, $tabela);
    $obj->id = $id;

    if ($obj->excluir()) {
        echo "Registro excluído com sucesso.";
    } else {
        echo "Erro ao excluir o registro.";
    }
} else {
    echo "Parâmetros inválidos.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Registros</title>
</head>
<body>
    <h2>Excluir Pessoa</h2>
    <a href="excluir.php?tabela=pessoa&id=1" onclick="return confirm('Deseja excluir a pessoa com ID 1?')">
        <button>Excluir Pessoa ID 1</button>
    </a>

    <h2>Excluir Produto</h2>
    <a href="excluir.php?tabela=produto&id=2" onclick="return confirm('Deseja excluir o produto com ID 2?')">
        <button>Excluir Produto ID 2</button>
    </a>
</body>
</html>

