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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Excluir Registros</h1>
        </header>

        <section>
            <h2>Excluir Pessoa</h2>
            <div class="btn-container">
                <a href="excluir.php?tabela=pessoa&id=1" onclick="return confirm('Deseja excluir a pessoa com ID 1?')">
                    <button class="excluir-btn">Excluir Pessoa ID 1</button>
                </a>
                <a href="excluir.php?tabela=pessoa&id=2" onclick="return confirm('Deseja excluir a pessoa com ID 2?')">
                    <button class="excluir-btn">Excluir Pessoa ID 2</button>
                </a>
                <a href="excluir.php?tabela=pessoa&id=3" onclick="return confirm('Deseja excluir a pessoa com ID 3?')">
                    <button class="excluir-btn">Excluir Pessoa ID 3</button>
                </a>
            </div>

            <h2>Excluir Produto</h2>
            <div class="btn-container">
                <a href="excluir.php?tabela=produto&id=1" onclick="return confirm('Deseja excluir o produto com ID 1?')">
                    <button class="excluir-btn">Excluir Produto ID 1</button>
                </a>
                <a href="excluir.php?tabela=produto&id=2" onclick="return confirm('Deseja excluir o produto com ID 2?')">
                    <button class="excluir-btn">Excluir Produto ID 2</button>
                </a>
                <a href="excluir.php?tabela=produto&id=3" onclick="return confirm('Deseja excluir o produto com ID 3?')">
                    <button class="excluir-btn">Excluir Produto ID 3</button>
                </a>
            </div>
        </section>
    </div>
</body>
</html>
