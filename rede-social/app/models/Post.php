<?php
function criarPostBanco($conexao, $id_usuario, $conteudo) {
    $id_usuario = (int) $id_usuario;
    $conteudo = mysqli_real_escape_string($conexao, $conteudo);
    $sql = "INSERT INTO posts (usuario_id, conteudo) VALUES ($id_usuario, '$conteudo')";

    return mysqli_query($conexao, $sql);
}

function listarFeedBanco($conexao) {
    $sql = "SELECT p.id, p.conteudo, p.created_at, u.nome, u.username, u.foto,
            (SELECT COUNT(*) FROM curtidas WHERE post_id = p.id) AS total_curtidas
            FROM posts p
            JOIN usuarios u ON p.usuario_id = u.id
            ORDER BY p.created_at DESC";
    $resultado = mysqli_query($conexao, $sql);

    if (!$resultado) {
        return [];
    }

    $posts = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $posts[] = $linha;
    }

    return $posts;
}

function contarPosts($conexao, $usuario_id) {
    $usuario_id = (int) $usuario_id;
    $sql = "SELECT COUNT(*) as total FROM posts WHERE usuario_id = $usuario_id";
    $res = mysqli_query($conexao, $sql);

    return $res ? (int) mysqli_fetch_assoc($res)['total'] : 0;
}

function listarPostsUsuario($conexao, $usuario_id) {
    $usuario_id = (int) $usuario_id;
    $sql = "SELECT p.id, p.conteudo, p.created_at, u.nome, u.username, u.foto,
            (SELECT COUNT(*) FROM curtidas WHERE post_id = p.id) AS total_curtidas
            FROM posts p
            JOIN usuarios u ON p.usuario_id = u.id
            WHERE p.usuario_id = $usuario_id
            ORDER BY p.created_at DESC";
    $resultado = mysqli_query($conexao, $sql);

    if (!$resultado) {
        return [];
    }

    $posts = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $posts[] = $linha;
    }

    return $posts;
}
?>
