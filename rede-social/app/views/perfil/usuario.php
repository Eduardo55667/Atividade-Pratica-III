<?php
$usuario_perfil = $usuario_perfil ?? [];
$posts = $posts ?? [];
$qtd_seguidores = $qtd_seguidores ?? 0;
$qtd_seguindo = $qtd_seguindo ?? 0;
$qtd_posts = $qtd_posts ?? 0;
$ja_segue = $ja_segue ?? false;

$titulo = "Perfil de " . ($usuario_perfil['nome'] ?? 'usuario');
$pagina = "usuario";

require_once "app/views/layouts/header.php";
require_once "app/views/layouts/menu.php";

$fotoPadrao = 'public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png';
$fotoBanco = $usuario_perfil['foto'] ?? '';
$fotoCaminho = ($fotoBanco !== '' && file_exists($fotoBanco)) ? $fotoBanco : $fotoPadrao;
$foto = url('/' . ltrim($fotoCaminho, '/'));
?>

<div class="container mt-4 pb-5">

    <div class="card p-4 mb-4 shadow-sm text-center">
        <img src="<?php echo htmlspecialchars($foto); ?>" 
             class="rounded-circle mx-auto mb-3" 
             style="width: 120px; height: 120px; object-fit: cover;">

        <h4><?php echo htmlspecialchars($usuario_perfil['nome'] ?? 'Usuario'); ?></h4>

        <p class="text-muted">
            @<?php echo htmlspecialchars($usuario_perfil['username'] ?? ''); ?>
        </p>

        <div class="d-flex justify-content-center gap-4 my-3">
            <div>
                <strong>
                    <span id="cont-seguidores"><?php echo (int) $qtd_seguidores; ?></span>
                </strong>
                <br>
                <small>Seguidores</small>
            </div>

            <div>
                <strong><?php echo (int) $qtd_seguindo; ?></strong>
                <br>
                <small>Seguindo</small>
            </div>

            <div>
                <strong><?php echo (int) $qtd_posts; ?></strong>
                <br>
                <small>Posts</small>
            </div>
        </div>

        <div>
            <button type="button" 
                    class="btn <?php echo $ja_segue ? 'btn-secondary' : 'btn-primary'; ?>" 
                    onclick="seguirUsuarioPerfil(<?php echo (int) $usuario_perfil['id']; ?>, this)">
                <?php echo $ja_segue ? 'Deixar de Seguir' : 'Seguir'; ?>
            </button>
        </div>
    </div>

    <hr>

    <h5 class="mb-4">
        Posts de <?php echo htmlspecialchars($usuario_perfil['nome'] ?? 'usuario'); ?>
    </h5>

    <div>
        <?php if (empty($posts)): ?>

            <p class="text-center text-muted">
                Este usuario ainda nao tem posts.
            </p>

        <?php else: ?>

            <?php foreach ($posts as $post): ?>

                <div class="card p-3 mb-3 shadow-sm post">

                    <p><?php echo htmlspecialchars($post['conteudo']); ?></p>

                    <hr class="text-muted my-2">

                    <div class="text-muted small">
                        <i class="bi bi-heart-fill text-danger"></i>
                        <?php echo (int) $post['total_curtidas']; ?> curtidas

                        <span class="ms-3">
                            <i class="bi bi-clock"></i>
                            <?php echo date("d/m/Y H:i", strtotime($post['created_at'])); ?>
                        </span>
                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>

<?php require_once "app/views/layouts/footer.php"; ?>