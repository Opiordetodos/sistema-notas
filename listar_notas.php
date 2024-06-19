<?php
include_once("conexao.php");

// Função para listar notas
function listarNotas($conexao) {
    $sql = "SELECT n.id, a.nome, d.nome as disciplina, n.nota 
             FROM Notas n 
             INNER JOIN Alunos a ON n.aluno_id = a.id 
             INNER JOIN Disciplinas d ON n.disciplina_id = d.id";
    $result = $conexao->query($sql);
// listar categorias
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $row["id"]. "</td>";
            echo "<td>". $row["nome"]. "</td>";
            echo "<td>". $row["disciplina"]. "</td>";
            echo "<td>". $row["nota"]. "</td>";
            echo "<td><a href='editar_nota.php?id=". $row["id"]. "'>Editar</a></td>";
            echo "<td><a href='excluir_nota.php?id=". $row["id"]. "'>Excluir</a></td>";
            echo "</tr>";
        //    VERIFICAR QUAL O ESTADO DO ALUNO
            if ($row["nota"] >= 6 && $row["nota"] < 10) {
                echo"<p>". $row["nome"]. " aprovada"."</p>" ;
            }
            elseif ($row["nota"] < 6) {
                echo"<p>". $row["nome"]. " reprovada"."</p>" ;
            }
            elseif ($row["nota"] == 10) {
                echo"<p>". $row["nome"]. " nota maxima"."</p>" ;
            }
        }
    } else {
        echo "Nenhuma nota encontrada.";
    }
}

?>

<h1>Lista de Notas</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Aluno</th>
        <th>Disciplina</th>
        <th>Nota</th>
        <th>Editar</th>
        <th>Excluir</th>
    </tr>
    
    <?php listarNotas($conexao);?>
</table>
<a href="index.php">sair</a>