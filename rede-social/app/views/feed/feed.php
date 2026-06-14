<?php
$titulo = "Feed";
$pagina = "feed";

require_once "app/views/layouts/header.php";
require_once "app/views/layouts/menu.php";

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

require_once "app/models/Comentarios.php";

$conexao = $conexao ?? conectarBanco();
$usuarioLogado = $usuarioLogado ?? ['nome' => 'usuario'];
$erro_post = $erro_post ?? '';
$posts = $posts ?? [];
$fotoPadrao = 'public/img/fotoperfil.jpg';

function fotoFeed($foto, $fotoPadrao) {
    $caminho = trim($foto ?? '');
    return url('/' . ltrim($caminho !== '' ? $caminho : $fotoPadrao, '/'));
}
?>

<div class="container mt-4 pb-5">

    <section class="card p-3 mb-4 border-0 shadow-sm">
        <div class="d-flex align-items-center">
            <img src="<?php echo htmlspecialchars(fotoFeed($usuarioLogado['foto'] ?? '', $fotoPadrao)); ?>" 
                 class="rounded-circle me-3" 
                 style="width: 60px; height: 60px; object-fit: cover;">

            <div>
                <strong><?php echo htmlspecialchars($usuarioLogado['nome'] ?? 'Usuario'); ?></strong><br>
                <span class="text-muted">
                    @<?php echo htmlspecialchars($usuarioLogado['username'] ?? 'usuario'); ?>
                </span>
            </div>
        </div>
    </section>

    <form method="POST" 
          action="<?php echo htmlspecialchars(url('/feed')); ?>" 
          class="card p-3 mb-4 border-0 shadow-sm">

        <input type="hidden" name="acao" value="postar">

        <input type="text" 
               name="conteudo" 
               class="form-control" 
               placeholder="Escreva algo...">

        <div class="text-end mt-2">
            <button type="submit" class="btn btn-primary">Publicar</button>
        </div>

        <p class="text-danger mt-2 mb-0">
            <?php echo htmlspecialchars($erro_post ?? ''); ?>
        </p>
    </form>

    <div>
        <?php if (empty($posts)): ?>

            <p class="text-center text-muted">Nenhum post ainda.</p>

        <?php else: ?>

            <?php foreach ($posts as $post): ?>

                <?php $comentarios = listarComentariosPost($conexao, $post['id']); ?>

                <div class="card p-3 mb-3 shadow-sm post" data-id="<?php echo (int) $post['id']; ?>">

                    <div class="d-flex align-items-center mb-2">
                        <img src="<?php echo htmlspecialchars(fotoFeed($post['foto'] ?? '', $fotoPadrao)); ?>" 
                             class="rounded-circle me-2" 
                             width="45" 
                             height="45" 
                             style="object-fit: cover;">

                        <div>
                            <strong><?php echo htmlspecialchars($post['nome']); ?></strong><br>
                            <span class="text-muted">
                                @<?php echo htmlspecialchars($post['username']); ?>
                            </span>
                        </div>
                    </div>

                    <p><?php echo htmlspecialchars($post['conteudo']); ?></p>

                    <hr class="text-muted my-2">

                    <div class="d-flex gap-3 mb-2">
                        <button type="button" 
                                class="btn btn-light text-secondary fw-bold border-0 bg-transparent curtir" 
                                onclick="curtirPost(<?php echo (int) $post['id']; ?>, this)">

                            <i class="bi bi-heart"></i> 
                            Curtir 
                            (<span class="contador"><?php echo (int) $post['total_curtidas']; ?></span>)
                        </button>

                        <button type="button" 
                                class="btn btn-light text-secondary fw-bold border-0 bg-transparent comentar" 
                                onclick="toggleComentarios(this)">

                            <i class="bi bi-chat-left-text"></i> 
                            Comentar 
                            (<span><?php echo count($comentarios); ?></span>)
                        </button>
                    </div>

                    <div class="comentarios-container d-none p-3 bg-light rounded mt-2">

                        <div class="lista-comentarios mb-3">

                            <?php if (empty($comentarios)): ?>

                                <p class="text-muted small mb-0 text-center py-2">
                                    Nenhum comentario ainda. Comece a conversa!
                                </p>

                            <?php else: ?>

                                <?php foreach ($comentarios as $c): ?>

                                    <div class="d-flex align-items-start mb-2 small">
                                        <img src="<?php echo htmlspecialchars(fotoFeed($c['foto'] ?? '', $fotoPadrao)); ?>" 
                                             class="rounded-circle me-2 mt-1" 
                                             width="30" 
                                             height="30" 
                                             style="object-fit: cover;">

                                        <div class="bg-white p-2 rounded w-100 border text-dark">
                                            <strong><?php echo htmlspecialchars($c['nome']); ?></strong>

                                            <span class="text-muted" style="font-size: 11px;">
                                                @<?php echo htmlspecialchars($c['username']); ?>
                                            </span>

                                            <p class="mb-0 mt-1 text-secondary">
                                                <?php echo htmlspecialchars($c['conteudo']); ?>
                                            </p>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                        <form method="POST" 
                              action="<?php echo htmlspecialchars(url('/comentar')); ?>" 
                              class="input-group">

                            <input type="hidden" 
                                   name="post_id" 
                                   value="<?php echo (int) $post['id']; ?>">

                            <input type="text" 
                                   name="conteudo" 
                                   class="form-control form-control-sm" 
                                   placeholder="Escreva um comentario..." 
                                   required 
                                   style="border-radius: 20px 0 0 20px;">

                            <button type="submit" 
                                    class="btn btn-sm btn-primary px-3" 
                                    style="border-radius: 0 20px 20px 0;">
                                Enviar
                            </button>
                        </form>

                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</div>

<?php require_once "app/views/layouts/footer.php"; ?>