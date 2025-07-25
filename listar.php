<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container"> 
    <header>
        <h1>Lista de Pessoas</h1> 
        <nav class="menu"> 
            <ul>
                <li><a href="listar.php">Lista</a></li> 
                <li><a href="integracao.php">Cadastrar Pessoa</a></li> 
                <li><a href="produto_cadastro.php">Cadastrar Produto</a></li>
            </ul>
        </nav>
    </header>

    <section> <!-- Seção onde os dados serão listados -->

        <?php
        // Inclui os arquivos com as classes necessárias
        require_once 'conexao.php';
        require_once 'pessoa.php';
        require_once 'produto.php';

        // Cria instância da classe de conexão com o banco de dados
        $database = new BancoDeDados();
        $db = $database->obterConexao(); // Obtém a conexão PDO

        // Verifica se a conexão falhou
        if ($db === null) {
            echo "<p class='error'>Erro: Não foi possível conectar ao banco de dados.</p>";
        } else {
            // Se conexão bem-sucedida, começa a exibir os dados

            echo "<h2>Pessoas Cadastradas</h2>";

            $pessoa = new Pessoa($db); // Instancia a classe Pessoa com a conexão
            $stmtP = $pessoa->ler(); // Chama o método para ler os dados das pessoas

            // Se encontrou pessoas
            if ($stmtP->rowCount() > 0) {
                // Percorre todas as pessoas
                while ($linha = $stmtP->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='pessoa'>"; // Div estilizada para exibir os dados
                    echo "<p><strong>ID:</strong> " . htmlspecialchars($linha['id']) . "</p>"; // Exibe ID
                    echo "<p><strong>Nome:</strong> " . htmlspecialchars($linha['nome']) . "</p>"; // Exibe nome
                    echo "<p><strong>Idade:</strong> " . htmlspecialchars($linha['idade']) . "</p>"; // Exibe idade
                    echo "<a href='editar_idade.php?id=" . $linha['id'] . "' class='editar-btn'>Alterar Idade</a>"; // Botão para editar idade
                    echo "</div>";
                }
            } else {
                // Se não encontrou pessoas
                echo "<p class='error'>Nenhuma pessoa cadastrada.</p>";
            }

            // Lista os produtos cadastrados
            echo "<h2>Produtos Cadastrados</h2>";

            $produto = new Produto($db); // Instancia a classe Produto
            $stmtProd = $produto->ler(); // Lê os produtos do banco

            // Se encontrou produtos
            if ($stmtProd->rowCount() > 0) {
                while ($linha = $stmtProd->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='pessoa'>"; // Usa a mesma classe CSS
                    echo "<p><strong>ID:</strong> " . htmlspecialchars($linha['id']) . "</p>"; // Exibe ID do produto
                    echo "<p><strong>Nome:</strong> " . htmlspecialchars($linha['nome']) . "</p>"; // Exibe nome do produto
                    echo "<p><strong>Preço:</strong> R$ " . number_format($linha['preco'], 2, ',', '.') . "</p>"; // Exibe preço formatado
                    echo "<a href='editar_produto.php?id=" . $linha['id'] . "' class='editar-btn'>Alterar Produto</a>";
                    echo "</div>";
                }
            } else {
                // Se não encontrou produtos
                echo "<p class='error'>Nenhum produto cadastrado.</p>";
            }
        }
        ?>
    </section>
</div>
</body>
</html>
