<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Cadastro de Produto</h1>
            <nav class="menu">
                <ul>
                <li><a href="listar.php">Lista</a></li>
                <li><a href="integracao.php">Cadastrar Pessoa</a></li>
                <li><a href="produto_cadastro.php">Cadastrar Produto</a></li>
                </ul>
            </nav>
        </header>

        <section>
            <?php
            require_once 'conexao.php';
            require_once 'produto.php';

            $mensagem = '';
            $cadastroSucesso = false;

            $database = new BancoDeDados();
            $db = $database->obterConexao();

            if ($db === null) {
                $mensagem = "Erro: Não foi possível conectar ao banco de dados";
            } else {
                $produto = new Produto($db);

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $produto->nome = $_POST['nome'];
                    $produto->preco = $_POST['preco'];

                    if ($produto->criar()) {
                        $mensagem = "Produto '{$produto->nome}' cadastrado com sucesso!";
                        $cadastroSucesso = true;
                    } else {
                        $mensagem = "Erro ao cadastrar o produto.";
                    }
                }
            }
            ?>

            <form action="" method="post" id="formCadastroProduto">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="preco">Preço:</label>
                <input type="number" step="0.01" id="preco" name="preco" required>

                <input type="submit" value="Cadastrar Produto">
            </form>
        </section>
    </div>

    <script>
        const mensagemDoPHP = "<?php echo $mensagem; ?>";
        const cadastroFoiSucesso = <?php echo json_encode($cadastroSucesso); ?>;

        if (mensagemDoPHP) {
            alert(mensagemDoPHP);
            if (cadastroFoiSucesso) {
                document.getElementById('nome').value = '';
                document.getElementById('preco').value = '';
                document.getElementById('nome').focus();
            }
        }
    </script>
</body>
</html>
