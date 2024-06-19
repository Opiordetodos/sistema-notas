<?php
include_once("conexao.php");

// Função para editar nota
function editarNota($conexao, $id, $aluno_id, $disciplina_id, $nota) {
    $sql = "UPDATE Notas SET aluno_id =?, disciplina_id =?, nota =? WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iiii", $aluno_id, $disciplina_id, $nota, $id);

    if ($stmt->execute()) {
        echo "Nota editada com sucesso!";
    } else {
        echo "Erro: ". $stmt->error;
    }

    $stmt->close();
}
// REQUISIÇÃO PARA A MUDANÇA DE NOTA
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id = $_POST["id"];
    $aluno_id = $_POST["aluno_id"];
    $disciplina_id = $_POST["disciplina_id"];
    $nota = $_POST["nota"];

    editarNota($conexao, $id, $aluno_id, $disciplina_id, $nota);
}

// Função para buscar nota por ID
function buscarNota($conexao, $id) {
    $sql = "SELECT * FROM notas WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc();
}

$id = $_GET["id"];
$nota = buscarNota($conexao, $id);

?>

<h1>Editar Nota</h1>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <input type="hidden" name="id" value="<?php echo $id;?>">
    <label for="aluno_id">Aluno ID:</label>
    <input type="number" id="aluno_id" name="aluno_id" value="<?php echo $nota["aluno_id"];?>" required><br><br>
    <label for="disciplina_id">Disciplina ID:</label>
    <input type="number" id="disciplina_id" name="disciplina_id" value="<?php echo $nota["disciplina_id"];?>" required><br><br>
    <label for="nota">Nota:</label>
    <input type="number" id="nota" name="nota" value="<?php echo $nota["nota"];?>" required><br><br>
    <input type="submit" value="Editar Nota">
    <a href="listar_notas.php">pagina de listagem</a>
</form>