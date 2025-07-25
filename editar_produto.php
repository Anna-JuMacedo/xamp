<?php
require_once 'conexao.php';
require_once 'produto.php';

$database = new BancoDeDados();
$db = $database->obterConexao();

if ($db === null) {
    die("Erro ao conectar com o banco de dados.");
}

$produto = new Produto($db);

if (!isset($_GET['id'])) {
    die("ID do produto não especificado.");
}

$id = $_GET['id'];
$dadosProduto = $produto->buscarPorId($id);

if (!$dadosProduto) {
    die("Produto não encontrado.");
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['atualizar'])) {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];

        if ($produto->editarProduto($id, $nome, $preco,)) {
            $mensagem = "Produto atualizado com sucesso!";
            $dadosProduto['nome'] = $nome;
            $dadosProduto['preco'] = $preco;
        } else {
            $mensagem = "Erro ao atualizar produto.";
        }
    }

    if (isset($_POST['excluir'])) {
        $produto->id = $id;
        if ($produto->excluir()) {
            header("Location: listar.php?mensagem=Produto+excluído+com+sucesso");
            exit;
        } else {
            $mensagem = "Erro ao excluir produto.";
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Editar Produto</h1>
            <nav class="menu">
                <ul>
                    <li><a href="listar.php">Listar Produtos</a></li>
                    <li><a href="produto_cadastro.php">Cadastrar Produto</a></li>
                    <li><a href="integracao.php">Cadastrar Pessoa</a></li>
                </ul>
            </nav>
        </header>

        <section>
            <h2><?php echo htmlspecialchars($dadosProduto['nome']); ?></h2>

            <?php if ($mensagem): ?>
                <p style="color: green;"><?php echo $mensagem; ?></p>
            <?php endif; ?>

            <!-- Formulário -->
            <form method="post">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($dadosProduto['nome']); ?>" required>

                <label for="preco">Preço:</label>
                <input type="number" step="any" name="preco" id="preco" value="<?php echo htmlspecialchars($dadosProduto['preco']); ?>" required>

                <input type="submit" name="atualizar" value="Atualizar Produto">
            </form>

            <!-- Formulário de exclusão -->
            <form method="post" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                <input type="hidden" name="excluir" value="1">
                <input type="submit" value="Excluir Produto" style="background-color: red; color: white;">
            </form>
        </section>
    </div>
</body>

</html>