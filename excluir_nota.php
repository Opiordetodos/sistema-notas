<?php
include_once("conexao.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM Notas WHERE id =?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: listar_notas.php");
    exit;
}

?>

<a href="listar_notas.php">Voltar</a>