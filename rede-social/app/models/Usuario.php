<?php
function buscarUsuarioEmail($conexao, $email) {
    $email = mysqli_real_escape_string($conexao, $email);
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    return $resultado ? mysqli_fetch_assoc($resultado) : null;
}

function cadastrarUsuarioBanco($conexao, $nome, $user, $email, $senha, $data, $genero) {
    $nome = mysqli_real_escape_string($conexao, $nome);
    $user = mysqli_real_escape_string($conexao, $user);
    $email = mysqli_real_escape_string($conexao, $email);
    $data = mysqli_real_escape_string($conexao, $data);
    $genero = mysqli_real_escape_string($conexao, $genero);

    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
    $fotoPadrao = "public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png";

    $sql = "INSERT INTO usuarios (nome, username, email, senha, data_nascimento, genero, foto)
            VALUES ('$nome', '$user', '$email', '$senhaHash', '$data', '$genero', '$fotoPadrao')";

    return mysqli_query($conexao, $sql);
}

function buscarUsuarioPorId($conexao, $id) {
    $id = (int) $id;
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);

    return $resultado ? mysqli_fetch_assoc($resultado) : null;
}

function atualizarFoto($conexao, $id, $foto_caminho) {
    $id = (int) $id;
    $foto_caminho = mysqli_real_escape_string($conexao, $foto_caminho);
    $sql = "UPDATE usuarios SET foto = '$foto_caminho' WHERE id = $id";

    return mysqli_query($conexao, $sql);
}

function atualizarSenha($conexao, $id, $nova_senha) {
    $id = (int) $id;
    $senhaHash = password_hash($nova_senha, PASSWORD_BCRYPT);
    $sql = "UPDATE usuarios SET senha = '$senhaHash' WHERE id = $id";

    return mysqli_query($conexao, $sql);
}

function pesquisarUsuarios($conexao, $termo, $usuario_logado_id) {
    $termo = mysqli_real_escape_string($conexao, $termo);
    $usuario_logado_id = (int) $usuario_logado_id;
    $sql = "SELECT id, nome, username, foto FROM usuarios
            WHERE (nome LIKE '%$termo%' OR username LIKE '%$termo%')
            AND id != $usuario_logado_id";
    $resultado = mysqli_query($conexao, $sql);

    if (!$resultado) {
        return [];
    }

    $usuarios = [];
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $usuarios[] = $linha;
    }

    return $usuarios;
}
?>
