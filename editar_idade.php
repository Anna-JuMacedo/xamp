<?php
require_once 'conexao.php';
require_once 'pessoa.php';

$database = new BancoDeDados();
$db = $database->obterConexao();

if ($db === null) {
    die("Erro ao conectar com o banco de dados.");
}

$pessoa = new Pessoa($db);

if (!isset($_GET['id'])) {
    die("ID não especificado.");
}

$id = $_GET['id'];
$dadosPessoa = $pessoa->buscarPorId($id);

if (!$dadosPessoa) {
    die("Pessoa não encontrada.");
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novaIdade = $_POST['idade'];

    if ($pessoa->altera_idade($id, $novaIdade)) {
        $mensagem = "Idade atualizada com sucesso!";
        $dadosPessoa['idade'] = $novaIdade;
    } else {
        $mensagem = "Erro ao atualizar idade.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Idade</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Editar Idade</h1>
            <nav class="menu">
                <ul>
                    <li><a href="listar.php">Lista</a></li>
                    <li><a href="integracao.php">Cadastrar Pessoa</a></li>
                    <li><a href="produto_cadastro.php">Cadastrar Produto</a></li>
                </ul>
            </nav>
        </header>

        <section>
            <h2><?php echo htmlspecialchars($dadosPessoa['nome']); ?></h2>

            <?php if ($mensagem): ?>
                <p style="color: green;"><?php echo $mensagem; ?></p>
            <?php endif; ?>

            <form method="post">
                <label for="idade">Nova idade:</label>
                <input type="number" name="idade" id="idade" value="<?php echo htmlspecialchars($dadosPessoa['idade']); ?>" required>
                <input type="submit" value="Atualizar Idade">
            </form>

            <form method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');">
                <input type="hidden" name="excluir" value="1">
                <input type="submit" value="Excluir Pessoa" style="background-color: red; color: white;">
            </form>
        </section>
    </div>
</body>

</html>