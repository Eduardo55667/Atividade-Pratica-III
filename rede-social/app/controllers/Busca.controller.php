<?php
require_once "app/models/Usuario.php";
require_once "app/models/Seguidor.php";

function controlarBusca() {
    if (!isset($_SESSION["usuario_logado"])) {
        header("Location: " . url('/login'));
        exit();
    }

    $conexao = conectarBanco();
    $usuarios_encontrados = [];
    $termo = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $termo = trim($_POST['busca'] ?? "");

        if ($termo !== "") {
            $usuarios_encontrados = pesquisarUsuarios($conexao, $termo, $_SESSION["usuario_logado"]["id"]);

            foreach ($usuarios_encontrados as &$usuario) {
                $usuario['segue'] = estaSeguindo($conexao, $_SESSION["usuario_logado"]["id"], $usuario['id']);
            }
            unset($usuario);
        }
    }

    require "app/views/busca/buscar.php";
}

function controlarSeguirAJAX() {
    if (!isset($_SESSION["usuario_logado"]) || !isset($_POST["alvo_id"])) {
        http_response_code(401);
        echo "nao_autorizado";
        exit();
    }

    $conexao = conectarBanco();
    echo alternarSeguirBanco($conexao, $_SESSION["usuario_logado"]["id"], $_POST["alvo_id"]);
    exit();
}
?>
