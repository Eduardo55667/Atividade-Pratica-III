<?php
require_once "app/models/Usuario.php";
require_once "app/models/Post.php";
require_once "app/models/Seguidor.php";

function controlarMeuPerfil() {
    if (!isset($_SESSION["usuario_logado"])) {
        header("Location: " . url('/login'));
        exit();
    }

    $conexao = conectarBanco();
    $uid = (int) $_SESSION["usuario_logado"]["id"];
    $erro = "";
    $sucesso = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $acao = $_POST['acao'] ?? "";

        if ($acao === 'alterar_foto') {
            if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
                $erro = "Selecione uma imagem valida.";
            } else {
                $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

                if (!in_array($extensao, ['jpg', 'jpeg', 'png'], true)) {
                    $erro = "Formato de imagem invalido. Use JPG ou PNG.";
                } else {
                    $nome_foto = "public/img/perfil_" . $uid . "_" . time() . "." . $extensao;

                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $nome_foto)) {
                        atualizarFoto($conexao, $uid, $nome_foto);
                        $_SESSION["usuario_logado"]["foto"] = $nome_foto;
                        $sucesso = "Foto atualizada com sucesso!";
                    } else {
                        $erro = "Nao foi possivel salvar a foto.";
                    }
                }
            }
        }

        if ($acao === 'alterar_senha') {
            $senha_atual = $_POST['senha_atual'] ?? "";
            $nova_senha = $_POST['nova_senha'] ?? "";
            $confirmar = $_POST['confirmar_senha'] ?? "";
            $usuario_bd = buscarUsuarioPorId($conexao, $uid);

            if (!$usuario_bd || !password_verify($senha_atual, $usuario_bd['senha'])) {
                $erro = "Senha atual incorreta.";
            } else if (strlen($nova_senha) < 6 || !preg_match("/[A-Z]/", $nova_senha) || !preg_match("/[0-9]/", $nova_senha)) {
                $erro = "A nova senha nao atende aos requisitos.";
            } else if ($nova_senha !== $confirmar) {
                $erro = "As senhas nao coincidem.";
            } else {
                atualizarSenha($conexao, $uid, $nova_senha);
                $sucesso = "Senha alterada com sucesso!";
            }
        }
    }

    $usuario = buscarUsuarioPorId($conexao, $uid);
    $qtd_seguidores = contarSeguidores($conexao, $uid);
    $qtd_seguindo = contarSeguindo($conexao, $uid);
    $qtd_posts = contarPosts($conexao, $uid);

    require "app/views/perfil/meuperfil.php";
}

function controlarPerfilAlheio() {
    if (!isset($_SESSION["usuario_logado"])) {
        header("Location: " . url('/login'));
        exit();
    }

    if (!isset($_GET['id'])) {
        header("Location: " . url('/feed'));
        exit();
    }

    $conexao = conectarBanco();
    $meu_id = (int) $_SESSION["usuario_logado"]["id"];
    $id_alvo = (int) $_GET['id'];

    if ($meu_id === $id_alvo) {
        header("Location: " . url('/perfil'));
        exit();
    }

    $usuario_perfil = buscarUsuarioPorId($conexao, $id_alvo);
    if (!$usuario_perfil) {
        header("Location: " . url('/feed'));
        exit();
    }

    $qtd_seguidores = contarSeguidores($conexao, $id_alvo);
    $qtd_seguindo = contarSeguindo($conexao, $id_alvo);
    $qtd_posts = contarPosts($conexao, $id_alvo);
    $ja_segue = estaSeguindo($conexao, $meu_id, $id_alvo);
    $posts = listarPostsUsuario($conexao, $id_alvo);

    require "app/views/perfil/usuario.php";
}
?>
