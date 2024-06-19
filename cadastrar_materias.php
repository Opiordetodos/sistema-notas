<?php
require_once 'conexao.php';

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obter dados do formulário
    $nome_disciplina = $_POST["nome_disciplina"];
    $descricao = $_POST["descricao"];

    // Preparar instrução SQL
    $sql = "INSERT INTO disciplinas (nome, descricao) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);

    // Vincular parâmetros e executar instrução
    $stmt->bind_param("ss", $nome_disciplina, $descricao);
    $stmt->execute();

    // Verificar se os dados foram inseridos com sucesso
    if ($stmt->affected_rows > 0) {
        echo "Disciplina cadastrada com sucesso!";
        header("location: index.php");
    } else {
        echo "Erro ao cadastrar a disciplina.";
        header("location: cadastrar_materias.php");
    }

    // Fechar instrução e conexão
    $stmt->close();
    $conexao->close();
}
?>

<!-- Formulário de cadastro de disciplina -->
<h2>Cadastro de Disciplina</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="nome_disciplina">Nome da disciplina:</label><br>
    <input type="text" id="nome_disciplina" name="nome_disciplina"><br>
    <label for="descricao">Descrição da disciplina:</label><br>
    <input type="text" id="descricao" name="descricao"><br>
    <input type="submit" value="Cadastrar disciplina">
</form>
<a href="index.php">sair</a>