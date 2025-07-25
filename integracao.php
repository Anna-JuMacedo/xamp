<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pessoa</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="container">
        <header>
            <h1>Cadastro de Pessoa</h1>
            <nav class="menu">
        <ul>
            <!-- Menu de navegação -->
                <li><a href="listar.php">Lista</a></li>
                <li><a href="integracao.php">Cadastrar Pessoa</a></li>
                <li><a href="produto_cadastro.php">Cadastrar Produto</a></li>
        </ul>
    </nav>
        </header>

        <section>
            <?php
            // Importa o arquivo de conexão com o banco de dados
            require_once 'conexao.php';

            // Importa a classe Pessoa com os métodos de manipulação de dados
            require_once 'pessoa.php';

            $mensagem = ''; // Inicializa a variável de mensagem
            $cadastroSucesso = false; // Variável de controle de sucesso

            // Cria uma instância da classe BancoDeDados
            $database = new BancoDeDados();

            // Obtém a conexão com o banco de dados
            $db = $database->obterConexao();

            // Verifica se a conexão falhou
            if ($db === null) {
                $mensagem = "Erro: Não foi possível conectar ao banco de dados";
            } else {
                // Cria uma instância da classe Pessoa passando a conexão
                $pessoa = new Pessoa($db);

                // Verifica se o formulário foi enviado via POST
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Define os valores recebidos no formulário nos atributos da pessoa
                    $pessoa->nome = $_POST['nome'];
                    $pessoa->idade = $_POST['idade'];

                    // Tenta cadastrar a pessoa no banco
                    if ($pessoa->criar()) {
                        $mensagem = "Pessoa '{$pessoa->nome}' cadastrada com sucesso!";
                        $cadastroSucesso = true; // Marca como sucesso
                    } else {
                        $mensagem = "Erro ao cadastrar a pessoa.";
                    }
                }
            }
            ?>

            <!-- Formulário de cadastro -->
            <form action="" method="post" id="formCadastroPessoa"> 
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="idade">Idade:</label>
                <input type="number" id="idade" name="idade" required>

                <input type="submit" value="Cadastrar">
            </form>
        </section>
    </div>

    <script>
        const mensagemDoPHP = "<?php echo $mensagem; ?>"; 
        // Pega a mensagem PHP e passa para o JavaScript

        const cadastroFoiSucesso = <?php echo json_encode($cadastroSucesso); ?>;
        // Passa o valor booleano do PHP para o JavaScript

        if (mensagemDoPHP) {
            alert(mensagemDoPHP); // Mostra a mensagem em um alert

            if (cadastroFoiSucesso) {
                // Se o cadastro foi um sucesso, limpa os campos
                document.getElementById('nome').value = '';
                document.getElementById('idade').value = '';
                document.getElementById('nome').focus(); 
            }
        }
    </script>
</body>
</html>
