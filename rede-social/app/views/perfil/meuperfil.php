<?php
$titulo = "Meu Perfil";
$pagina = "perfil";

require_once "app/views/layouts/header.php";
require_once "app/views/layouts/menu.php";

$usuario = $usuario ?? [];
$erro = $erro ?? '';
$sucesso = $sucesso ?? '';
$qtd_seguidores = $qtd_seguidores ?? 0;
$qtd_seguindo = $qtd_seguindo ?? 0;
$qtd_posts = $qtd_posts ?? 0;

$fotoPadrao = 'public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png';
$fotoBanco = $usuario['foto'] ?? '';
$fotoCaminho = ($fotoBanco !== '' && file_exists($fotoBanco)) ? $fotoBanco : $fotoPadrao;
$foto = url('/' . ltrim($fotoCaminho, '/'));
?>

<div class="container mt-4 pb-5">

    <?php if ($sucesso !== ''): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($sucesso); ?>
        </div>
    <?php endif; ?>

    <?php if ($erro !== ''): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($erro); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-4 mb-4 shadow-sm text-center">

                <img src="<?php echo htmlspecialchars($foto); ?>" 
                     class="rounded-circle mx-auto mb-3" 
                     style="width: 150px; height: 150px; object-fit: cover;">

                <h4><?php echo htmlspecialchars($usuario['nome'] ?? 'Usuario'); ?></h4>

                <p class="text-muted">
                    @<?php echo htmlspecialchars($usuario['username'] ?? ''); ?>
                </p>

                <div class="d-flex justify-content-around my-3">
                    <div>
                        <strong><?php echo (int) $qtd_seguidores; ?></strong><br>
                        <small>Seguidores</small>
                    </div>

                    <div>
                        <strong><?php echo (int) $qtd_seguindo; ?></strong><br>
                        <small>Seguindo</small>
                    </div>

                    <div>
                        <strong><?php echo (int) $qtd_posts; ?></strong><br>
                        <small>Posts</small>
                    </div>
                </div>

                <hr>

                <p class="text-start">
                    <strong>Email:</strong> 
                    <?php echo htmlspecialchars($usuario['email'] ?? ''); ?>
                </p>

                <p class="text-start">
                    <strong>Nascimento:</strong> 
                    <?php echo !empty($usuario['data_nascimento']) ? date("d/m/Y", strtotime($usuario['data_nascimento'])) : ''; ?>
                </p>

                <p class="text-start">
                    <strong>Genero:</strong> 
                    <?php echo htmlspecialchars(ucfirst($usuario['genero'] ?? '')); ?>
                </p>

                <form method="POST" action="<?php echo url('/perfil'); ?>" enctype="multipart/form-data" class="mt-3 text-start">
                    <input type="hidden" name="acao" value="alterar_foto">

                    <label class="form-label fw-bold">Alterar foto de perfil:</label>

                    <div class="input-group">
                        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png" required>
                        <button type="submit" class="btn btn-primary">Salvar Foto</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 shadow-sm">

                <h5 class="mb-3">Alterar Senha</h5>

                <form method="POST" action="<?php echo url('/perfil'); ?>">
                    <input type="hidden" name="acao" value="alterar_senha">

                    <div class="mb-3">
                        <label>Senha Atual</label>
                        <input type="password" name="senha_atual" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Nova Senha</label>
                        <input type="password" name="nova_senha" class="form-control" required>
                        <small class="text-muted">Minimo 6 caracteres, 1 maiuscula e 1 numero.</small>
                    </div>

                    <div class="mb-3">
                        <label>Confirmar Nova Senha</label>
                        <input type="password" name="confirmar_senha" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        Salvar Senha
                    </button>
                </form>

            </div>
        </div>
    </div>

</div>

<?php require_once "app/views/layouts/footer.php"; ?>