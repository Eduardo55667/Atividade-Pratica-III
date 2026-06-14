<?php
// app/controllers/PostController.php

require_once "app/models/Post.php";
require_once "app/models/Curtida.php";
require_once "app/models/Comentarios.php";

function controlarFeed() {
    if (!isset($_SESSION["usuario_logado"])) {
        header("Location: " . url('/login'));
        exit();
    }

    $erro_post = "";
    $conexao = conectarBanco();
    $usuarioLogado = $_SESSION["usuario_logado"];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST["acao"] ?? "") === "postar") {
        $conteudo = trim($_POST["conteudo"] ?? "");

        if ($conteudo === "") {
            $erro_post = "O campo de post nao pode estar vazio.";
        } else {
            criarPostBanco($conexao, $usuarioLogado["id"], $conteudo);
            header("Location: " . url('/feed'));
            exit();
        }
    }

    $posts = listarFeedBanco($conexao);
    require "app/views/feed/feed.php";
}

function controlarCurtidaAJAX() {
    if (!isset($_SESSION["usuario_logado"]) || !isset($_POST["post_id"])) {
        http_response_code(401);
        echo "nao_autorizado";
        exit();
    }

    $conexao = conectarBanco();
    echo curtirPostBanco($conexao, $_SESSION["usuario_logado"]["id"], $_POST["post_id"]);
    exit();
}

function controlarComentario() {
    if (!isset($_SESSION["usuario_logado"])) {
        header("Location: " . url('/login'));
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["conteudo"]) && isset($_POST["post_id"])) {
        $conexao = conectarBanco();
        $usuario_id = $_SESSION["usuario_logado"]["id"];
        $post_id = (int)$_POST["post_id"];
        $conteudo = trim($_POST["conteudo"]);

        if ($conteudo !== "") {
            // Salva no banco higienizando contra tags HTML maliciosas
            criarComentarioBanco($conexao, $post_id, $usuario_id, htmlspecialchars($conteudo));
        }
    }
    
    // Redireciona de volta para o feed atualizado
    header("Location: " . url('/feed'));
    exit();
}
?>
