<?php
// app/models/Comentarios.php

function criarComentarioBanco($conexao, $post_id, $usuario_id, $conteudo) {
    $post_id = (int)$post_id;
    $usuario_id = (int)$usuario_id;
    $conteudo = mysqli_real_escape_string($conexao, $conteudo);
    
    $sql = "INSERT INTO comentarios (post_id, usuario_id, conteudo) VALUES ($post_id, $usuario_id, '$conteudo')";
    return mysqli_query($conexao, $sql);
}

function listarComentariosPost($conexao, $post_id) {
    $post_id = (int)$post_id;
    $sql = "SELECT c.*, u.nome, u.username, u.foto 
            FROM comentarios c 
            JOIN usuarios u ON c.usuario_id = u.id 
            WHERE c.post_id = $post_id 
            ORDER BY c.id ASC";
            
    $resultado = mysqli_query($conexao, $sql);

    if (!$resultado) {
        return [];
    }
    
    $comentarios = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $comentarios[] = $linha;
    }
    return $comentarios;
}
?>
