<?php
// routes/web.php

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

if (!function_exists('url')) {
    function url($caminho = '') {
        return BASE_URL . '/' . ltrim($caminho, '/');
    }
}

// Trata a URL vinda por parâmetro GET (ex: index.php?url=feed)
$url = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : '/';

switch ($url) {
    // --- ROTAS DE AUTENTICAÇÃO ---
    case '/':
    case '/login':
        require_once "app/controllers/AuthController.php";
        controlarLogin();
        break;
    case '/cadastro':
        require_once "app/controllers/AuthController.php";
        controlarCadastro();
        break;
    case '/sair':
        require_once "app/controllers/AuthController.php";
        controlarSair();
        break;

    // --- ROTAS DE POSTS, CURTIDAS E COMENTÁRIOS ---
    case '/feed':
        require_once "app/controllers/PostController.php";
        controlarFeed();
        break;
    case '/curtir':
        require_once "app/controllers/PostController.php";
        controlarCurtidaAJAX();
        break;
    case '/comentar': // Nova rota adicionada para os comentários!
        require_once "app/controllers/PostController.php";
        controlarComentario();
        break;

    // --- ROTAS DE PERFIL ---
    case '/perfil':
        require_once "app/controllers/Perfil.controller.php";
        controlarMeuPerfil();
        break;
    case '/usuario':
        require_once "app/controllers/Perfil.controller.php";
        controlarPerfilAlheio();
        break;

    // --- ROTAS DE BUSCA E SEGUIDORES ---
    case '/usuarios':
        require_once "app/controllers/Busca.controller.php";
        controlarBusca();
        break;
    case '/seguir':
        require_once "app/controllers/Busca.controller.php";
        controlarSeguirAJAX();
        break;

    // --- PÁGINA NÃO ENCONTRADA ---
    default:
        http_response_code(404);
        echo "<h1>Erro 404 - Pagina nao encontrada</h1>";
        break;
}
?>
