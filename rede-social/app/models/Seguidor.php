<?php
function contarSeguidores($conexao, $usuario_id) {
    $usuario_id = (int) $usuario_id;
    $sql = "SELECT COUNT(*) as total FROM seguidores WHERE seguindo_id = $usuario_id";
    $res = mysqli_query($conexao, $sql);

    return $res ? (int) mysqli_fetch_assoc($res)['total'] : 0;
}

function contarSeguindo($conexao, $usuario_id) {
    $usuario_id = (int) $usuario_id;
    $sql = "SELECT COUNT(*) as total FROM seguidores WHERE seguidor_id = $usuario_id";
    $res = mysqli_query($conexao, $sql);

    return $res ? (int) mysqli_fetch_assoc($res)['total'] : 0;
}

function estaSeguindo($conexao, $seguidor_id, $seguindo_id) {
    $seguidor_id = (int) $seguidor_id;
    $seguindo_id = (int) $seguindo_id;
    $sql = "SELECT id FROM seguidores WHERE seguidor_id = $seguidor_id AND seguindo_id = $seguindo_id";
    $res = mysqli_query($conexao, $sql);

    return $res ? mysqli_num_rows($res) > 0 : false;
}

function alternarSeguirBanco($conexao, $seguidor_id, $seguindo_id) {
    $seguidor_id = (int) $seguidor_id;
    $seguindo_id = (int) $seguindo_id;

    if ($seguidor_id <= 0 || $seguindo_id <= 0 || $seguidor_id === $seguindo_id) {
        return "erro";
    }

    if (estaSeguindo($conexao, $seguidor_id, $seguindo_id)) {
        mysqli_query($conexao, "DELETE FROM seguidores WHERE seguidor_id = $seguidor_id AND seguindo_id = $seguindo_id");
        return "removido";
    }

    mysqli_query($conexao, "INSERT INTO seguidores (seguidor_id, seguindo_id) VALUES ($seguidor_id, $seguindo_id)");
    return "adicionado";
}
?>
