<?php
include_once("conexao.php");

?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
  <label for="aluno_id">Aluno ID:</label>
  <input type="number" id="aluno_id" name="aluno_id" required><br><br>
  <label for="disciplina_id">Disciplina ID:</label>
  <input type="number" id="disciplina_id" name="disciplina_id" required><br><br>
  <label for="nota">Nota:</label>
  <input type="number" id="nota" name="nota" required><br><br>
  <input type="submit" value="Adicionar Nota">
</form>

<?php

// Função para verificar se o aluno existe
function alunoExiste($conexao, $aluno_id) {
    $sql = "SELECT * FROM alunos WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $aluno_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->num_rows > 0;
}

// Função para inserir uma nota
function insertNota($conexao, $aluno_id, $disciplina_id, $nota) {
    $sql = "INSERT INTO Notas (aluno_id, disciplina_id, nota) VALUES (?,?,?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iid", $aluno_id, $disciplina_id, $nota);

    if ($stmt->execute()) {
        echo "Nota inserida com sucesso!";
    } else {
        echo "Erro: ". $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $aluno_id = $_POST["aluno_id"];
    $disciplina_id = $_POST["disciplina_id"];
    $nota = $_POST["nota"];

    if (alunoExiste($conexao, $aluno_id)) {
        insertNota($conexao, $aluno_id, $disciplina_id, $nota);
    } else {
        echo "Erro: Aluno não encontrado!";
    }
    header("location: listar_notas.php");
}
?>
<a href="index.php">sair</a>