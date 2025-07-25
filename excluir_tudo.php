<?php
require_once 'conexao.php';

$tabelasPermitidas = ['pessoas', 'produtos'];

if (isset($_GET['id']) && isset($_GET['tabela'])) {
    $id = $_GET['id'];
    $tabela = $_GET['tabela'];

    if (!in_array($tabela, $tabelasPermitidas)) {
        echo '';
        exit;
    }

    $stmt = $conexao->prepare("SELECT nome FROM $tabela WHERE id = ?");
    $stmt->execute([$id]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $registro ? $registro['nome'] : '';
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
            <a href="#" onclick="confirmarExclusao('pessoas', 1)">
                <button class="excluir-btn">Excluir Pessoa ID 1</button>
            </a>
            <a href="#" onclick="confirmarExclusao('pessoas', 2)">
                <button class="excluir-btn">Excluir Pessoa ID 2</button>
            </a>
            <a href="#" onclick="confirmarExclusao('pessoas', 3)">
                <button class="excluir-btn">Excluir Pessoa ID 3</button>
            </a>
        </div>

        <h2>Excluir Produto</h2>
        <div class="btn-container">
            <a href="#" onclick="confirmarExclusao('produtos', 1)">
                <button class="excluir-btn">Excluir Produto ID 1</button>
            </a>
            <a href="#" onclick="confirmarExclusao('produtos', 2)">
                <button class="excluir-btn">Excluir Produto ID 2</button>
            </a>
            <a href="#" onclick="confirmarExclusao('produtos', 3)">
                <button class="excluir-btn">Excluir Produto ID 3</button>
            </a>
        </div>
    </section>
</div>

<script>
function confirmarExclusao(tabela, id) {
    fetch(`obter_nome.php?tabela=${tabela}&id=${id}`)
        .then(response => response.text())
        .then(nome => {
            if (!nome) {
                alert('Nome não encontrado.');
                return;
            }

            const confirmar = confirm(`Deseja excluir "${nome}" da tabela "${tabela}"?`);
            if (confirmar) {
                window.location.href = `excluir.php?tabela=${tabela}&nome=${encodeURIComponent(nome)}`;
            }
        })
        .catch(error => {
            alert('Erro ao buscar o nome.');
            console.error(error);
        });

    return false;
}
</script>

</body>
</html>
