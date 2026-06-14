<?php
function curtirPostBanco($conexao, $usuario_id, $post_id) {
    $usuario_id = (int) $usuario_id;
    $post_id = (int) $post_id;

    if ($usuario_id <= 0 || $post_id <= 0) {
        return "erro";
    }

    $sqlBusca = "SELECT id FROM curtidas WHERE usuario_id = $usuario_id AND post_id = $post_id";
    $resultado = mysqli_query($conexao, $sqlBusca);

    if (!$resultado) {
        return "erro";
    }

    if (mysqli_num_rows($resultado) > 0) {
        mysqli_query($conexao, "DELETE FROM curtidas WHERE usuario_id = $usuario_id AND post_id = $post_id");
        return "removido";
    }

    mysqli_query($conexao, "INSERT INTO curtidas (usuario_id, post_id) VALUES ($usuario_id, $post_id)");
    return "adicionado";
}
?>
