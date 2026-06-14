<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

if (!function_exists('url')) {
    function url($caminho = '') {
        return BASE_URL . '/' . ltrim($caminho, '/');
    }
}

$erro = $erro ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link rel="icon" href="<?php echo url('/public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png'); ?>" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo url('/public/CSS/cadastro.css'); ?>">
</head>
<body class="auth-page" style="background-color: #eee;">
  <main class="auth-content">
  <div class="container mt-5">
    <h2>Criar Conta</h2>
    <form method="POST" action="<?php echo url('/cadastro'); ?>">
      <input type="text" name="nome" class="form-control mb-2" placeholder="Nome">
      <input type="text" name="username" class="form-control mb-2" placeholder="Usuario">
      <input type="email" name="email" class="form-control mb-2" placeholder="Email">
      <input type="date" name="data" class="form-control mb-2">
      <select name="genero" class="form-control mb-2">
        <option value="">Selecione</option>
        <option value="feminino">Feminino</option>
        <option value="masculino">Masculino</option>
        <option value="outro">Outro</option>
      </select>
      <input type="password" name="senha" class="form-control mb-2" placeholder="Senha">
      <input type="password" name="confirmar" class="form-control mb-2" placeholder="Confirmar senha">
      <p class="text-danger"><?php echo htmlspecialchars($erro); ?></p>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
      <a href="<?php echo url('/login'); ?>" class="ms-3">Ja tenho conta</a>
    </form>
  </div>
  </main>

  <footer class="auth-footer bg-white text-center p-3 shadow-sm">
    <p class="mb-0 text-muted">
      &copy; <?php echo date('Y'); ?> Rede Social - Todos os direitos reservados
    </p>
  </footer>
</body>
</html>
