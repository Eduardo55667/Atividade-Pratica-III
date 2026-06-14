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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <link rel="icon" href="<?php echo url('/public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png'); ?>" type="image/png">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo url('/public/CSS/style.css'); ?>">
</head>
<body class="auth-page" style="background-color: #eee;">
  <main class="auth-content">
  <section>
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          
          <div class="card text-black shadow" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center align-items-center">

                <div class="col-md-10 col-lg-6 col-xl-6 d-flex align-items-center order-1 order-lg-1">
                  <img src="<?php echo url('/public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png'); ?>" class="img-fluid" alt="Cia do Nerd Logo">
                </div>

                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-2 d-flex flex-column justify-content-center">
                  
                  <p class="text-center h3 fw-bold mb-2 mx-1 mx-md-4 mt-4">BEM VINDO A CIA DO NERD</p>
                  <p class="text-center h5 fw-bold mb-4 mx-1 mx-md-4 text-muted">FAÇA SEU LOGIN</p>

                  <form method="POST" action="<?php echo url('/login'); ?>" class="mx-1 mx-md-4">
                    <div class="mb-4">
                      <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                    </div>
                    
                    <div class="mb-4">
                      <input type="password" name="senha" class="form-control form-control-lg" placeholder="Senha" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100">Entrar</button>
                    
                    <p class="text-danger mt-2 fw-bold text-center"><?php echo htmlspecialchars($erro); ?></p>
                    
                    <div class="text-center mt-3">
                      <a href="<?php echo url('/cadastro'); ?>" class="text-decoration-none fw-bold">Criar conta</a>
                    </div>
                  </form>

                </div>

              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>
  </main>

  <footer class="auth-footer bg-white text-center p-3 shadow-sm">
    <p class="mb-0 text-muted">
      &copy; <?php echo date('Y'); ?> Rede Social - Todos os direitos reservados
    </p>
  </footer>
</body>
</html>
