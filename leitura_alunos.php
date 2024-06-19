<?php
require_once 'conexao.php';

// Função para ler todos os alunos
function readAlunos($conexao) {
    $sql = "SELECT * FROM alunos";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: ". $row["id"]. " - Nome: ". $row["nome"]. " - Email: ". $row["email"]. " - Data de Nascimento: ". $row["data_nascimento"]. "<br>";
            echo "<a href='?acao=delete&id=".$row["id"]."'>Deletar</a> | ";
            echo "<a href='?acao=update&id=".$row["id"]."'>Editar</a><br><br>";
        }
    } else {
        echo "Nenhum aluno encontrado.";
    }
}

// Função para deletar um aluno
function deleteAluno($conexao, $id) {
    $sql = "DELETE FROM alunos WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: leitura_alunos.php");
    exit;
}

// Função para atualizar um aluno
function updateAluno($conexao, $id) {
    $sql = "SELECT * FROM alunos WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
      ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="student_id" value="<?php echo $row["id"];?>">
            Nome: <input type="text" name="name" value="<?php echo $row["nome"];?>"><br>
            Email: <input type="text" name="email" value="<?php echo $row["email"];?>"><br>
            Data de Nascimento: <input type="date" name="data_nascimento" value="<?php echo $row["data_nascimento"];?>"><br>
            <input type="submit" value="Atualizar">
        </form>
        <?php
    } else {
        echo "Nenhum aluno encontrado.";
    }
}

// Verificar se há uma ação para realizar
if (isset($_GET["acao"])) {
    switch ($_GET["acao"]) {
        case "delete":
            deleteAluno($conexao, $_GET["id"]);
            break;
        case "update":
            updateAluno($conexao, $_GET["id"]);
            break;
    }
} elseif (isset($_POST["student_id"])) {
    $student_id = $_POST["student_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $data_nascimento = $_POST["data_nascimento"];

    $sql = "UPDATE alunos SET nome =?, email =?, data_nascimento =? WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $data_nascimento, $student_id);
    $stmt->execute();
    header("Location: leitura_alunos.php");
    exit;
}

// Chamar a função para ler os alunos
readAlunos($conexao);

// Fechar a conexão com o banco de dados
$conexao->close();
?>
<a href="index.php">sair</a>