<?php
session_start();
require_once "config/database.php";

$baseUrl = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = $baseUrl === '/' ? '' : rtrim($baseUrl, '/');
define('BASE_URL', $baseUrl);

function url($caminho = '') {
    return BASE_URL . '/' . ltrim($caminho, '/');
}

$url = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
if (!isset($_GET['url']) && BASE_URL !== '' && str_starts_with($url, BASE_URL)) {
    $url = substr($url, strlen(BASE_URL)) ?: '/';
}
if ($url === '/index.php') {
    $url = '/';
}

switch ($url) {
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
    case '/feed':
        require_once "app/controllers/PostController.php";
        controlarFeed();
        break;
    case '/curtir':
        require_once "app/controllers/PostController.php";
        controlarCurtidaAJAX();
        break;
    case '/comentar':
        require_once "app/controllers/PostController.php";
        controlarComentario();
        break;
    case '/perfil':
        require_once "app/controllers/Perfil.controller.php";
        controlarMeuPerfil();
        break;
    case '/usuarios':
        require_once "app/controllers/Busca.controller.php";
        controlarBusca();
        break;
    case '/usuario':
        require_once "app/controllers/Perfil.controller.php";
        controlarPerfilAlheio();
        break;
    case '/seguir':
        require_once "app/controllers/Busca.controller.php";
        controlarSeguirAJAX();
        break;
    default:
        http_response_code(404);
        echo "<h1>Erro 404 - Pagina nao encontrada</h1>";
        break;
}
?>
