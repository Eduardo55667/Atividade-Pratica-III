<?php
function conectarBanco() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "rede_social";

    $conexao = mysqli_connect($host, $user, $pass, $db);
    if (!$conexao) {
        die("Erro no banco: " . mysqli_connect_error());
    }
    mysqli_set_charset($conexao, "utf8mb4");
    return $conexao;
}
?>