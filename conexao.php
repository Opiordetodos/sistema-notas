<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "notas";

// CRIAR connection
$conexao = mysqli_connect($servername, $username, $password, $db);

// CHECAR connection
if (!$conexao) {
    die("Connection failed: ". mysqli_connect_error());
}else{
echo "conexão feita com sucesso<br>";
}

?>