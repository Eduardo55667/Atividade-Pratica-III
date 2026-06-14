<?php
require_once "app/models/Usuario.php";

function controlarLogin() {
    $erro = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST["email"] ?? "");
        $senha = trim($_POST["senha"] ?? "");

        if ($email === "" || $senha === "") {
            $erro = "Preencha e-mail e senha.";
        } else {
            $conexao = conectarBanco();
            $usuario = buscarUsuarioEmail($conexao, $email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION["usuario_logado"] = $usuario;
                header("Location: " . url('/feed'));
                exit();
            }

            $erro = "E-mail ou senha incorretos.";
        }
    }

    require "app/views/auth/login.php";
}

function controlarCadastro() {
    $erro = "";
    $nome = $username = $email = $data = $genero = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = trim($_POST["nome"] ?? "");
        $username = trim($_POST["username"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $senha = trim($_POST["senha"] ?? "");
        $confirmar = trim($_POST["confirmar"] ?? "");
        $data = trim($_POST["data"] ?? "");
        $genero = trim($_POST["genero"] ?? "");

        if ($nome === "" || $username === "" || $email === "" || $senha === "" || $confirmar === "" || $data === "" || $genero === "") {
            $erro = "Preencha todos os campos.";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "E-mail invalido.";
        } else if (strlen($senha) < 6 || !preg_match("/[A-Z]/", $senha) || !preg_match("/[0-9]/", $senha)) {
            $erro = "Senha invalida (minimo 6 caracteres, 1 maiuscula e 1 numero).";
        } else if ($senha !== $confirmar) {
            $erro = "Senhas nao coincidem.";
        } else {
            $conexao = conectarBanco();

            if (cadastrarUsuarioBanco($conexao, $nome, $username, $email, $senha, $data, $genero)) {
                header("Location: " . url('/login'));
                exit();
            }

            $erro = "Erro ao cadastrar. E-mail ou usuario ja existem.";
        }
    }

    require "app/views/auth/cadastro.php";
}

function controlarSair() {
    unset($_SESSION["usuario_logado"]);
    header("Location: " . url('/login'));
    exit();
}
?>
