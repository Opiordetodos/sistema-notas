<?php
require_once 'conexao.php';

// Função para ler todas as disciplinas
function readDisciplinas($conexao) {
    $sql = "SELECT * FROM disciplinas";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "ID: ". $row["id"]. " - Nome: ". $row["nome"]. " - Descrição: ". $row["descricao"];
            echo " <a href='".$_SERVER["PHP_SELF"]."?acao=delete&id=".$row["id"]."'>Deletar</a> | ";
            echo " <a href='".$_SERVER["PHP_SELF"]."?acao=edit&id=".$row["id"]."'>Editar</a><br>";
        }
    } else {
        echo "Nenhuma disciplina encontrada.";
    }
}

// Função para deletar uma disciplina
function deleteDisciplina($id, $conexao) {
    $sql = "DELETE FROM disciplinas WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "Disciplina deletada com sucesso!<br>";
}

// Função para atualizar uma disciplina
function updateDisciplina($id, $nome, $descricao, $conexao) {
    $sql = "UPDATE disciplinas SET nome =?, descricao =? WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssi", $nome, $descricao, $id);
    $stmt->execute();
    $stmt->close();
    echo "Disciplina atualizada com sucesso!<br>";
}

// Verificar se há uma ação para realizar
if (isset($_GET["acao"])) {
    switch ($_GET["acao"]) {
        case "delete":
            deleteDisciplina($_GET["id"], $conexao);
            break;
        case "edit":
            $id = $_GET["id"];
            $sql = "SELECT * FROM disciplinas WHERE id =?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($result->num_rows > 0) {
                ?>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                    <input type="hidden" name="acao" value="update">
                    Nome: <input type="text" name="nome" value="<?php echo $row["nome"];?>"><br>
                    Descrição: <input type="text" name="descricao" value="<?php echo $row["descricao"];?>"><br>
                    <input type="submit" value="Atualizar">
                </form>
                <?php
            } else {
                echo "Nenhuma disciplina encontrada.";
            }
            break;
    }
}

// Verificar se há uma ação para realizar (update)
if (isset($_POST["acao"])) {
    switch ($_POST["acao"]) {
        case "update":
            updateDisciplina($_POST["id"], $_POST["nome"], $_POST["descricao"], $conexao);
            break;
    }
}

// Chamar a função para ler as disciplinas
readDisciplinas($conexao);
?>

<a href="index.php">sair</a>