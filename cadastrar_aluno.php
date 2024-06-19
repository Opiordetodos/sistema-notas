<?php
require_once 'conexao.php';

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obter dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];

    // Preparar instrução SQL
    $sql = "INSERT INTO alunos (nome, email, data_nascimento) VALUES (?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    // Vincular parâmetros e executar instrução
    $stmt->bind_param("sss", $nome, $email, $data_nascimento);
    $stmt->execute();

    // Verificar se os dados foram inseridos com sucesso
    if ($stmt->affected_rows > 0) {
        echo "Aluno cadastrado com sucesso!";
        header("location: index.php");
        
    } else {
        echo "Erro ao cadastrar aluno.";
        header("location: cadastrar_aluno.php");
        
    }

    // Fechar instrução e conexão
    $stmt->close();
    $conexao->close();
}
?>

<!-- Formulário de cadastro de aluno -->
<h2>Cadastro de Aluno</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome"><br>
    <label for="email">E-mail:</label><br>
    <input type="email" id="email" name="email"><br>
    <label for="data_nascimento">Data de Nascimento:</label><br>
    <input type="date" id="data_nascimento" name="data_nascimento"><br><br>
    <input type="submit" value="Cadastrar Aluno">
</form>
<a href="index.php">sair</a>