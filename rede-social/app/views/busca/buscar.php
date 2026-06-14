<?php
$titulo = "Buscar Usuarios";
$pagina = "usuarios";

require_once "app/views/layouts/header.php";
require_once "app/views/layouts/menu.php";

$termo = $termo ?? '';
$usuarios_encontrados = $usuarios_encontrados ?? [];
?>

<div class="container busca-page mt-4 pb-5">

    <div class="card busca-form-card p-4 shadow-sm mb-4">
        <form method="POST" action="<?php echo url('/usuarios'); ?>">
            <div class="input-group busca-input-group">
                <input
                    type="text"
                    name="busca"
                    class="form-control"
                    placeholder="Buscar por nome ou @username"
                    value="<?php echo htmlspecialchars($termo); ?>"
                    required
                >

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>

    <div class="row">

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>

            <?php if (empty($usuarios_encontrados)): ?>

                <p class="text-center text-muted">
                    Nenhum usuario encontrado.
                </p>

            <?php else: ?>

                <?php foreach ($usuarios_encontrados as $u): ?>

                    <?php
                    $fotoPadrao = 'public/img/Neon Green and Black Graffiti Urban Grunge Logo_20250202_220936_0000.png';
                    $fotoBanco = $u['foto'] ?? '';
                    $fotoCaminho = ($fotoBanco !== '' && file_exists($fotoBanco))
                        ? $fotoBanco
                        : $fotoPadrao;

                    $foto = url('/' . ltrim($fotoCaminho, '/'));
                    ?>

                    <div class="col-md-6 mb-3">

                        <div class="card usuario-card p-3 shadow-sm d-flex flex-row align-items-center justify-content-between">

                            <div class="usuario-info d-flex align-items-center">

                                <img
                                    src="<?php echo htmlspecialchars($foto); ?>"
                                    class="rounded-circle me-3"
                                    style="width: 50px; height: 50px; object-fit: cover;"
                                >

                                <div>
                                    <strong>
                                        <?php echo htmlspecialchars($u['nome']); ?>
                                    </strong>
                                    <br>

                                    <span class="text-muted">
                                        @<?php echo htmlspecialchars($u['username']); ?>
                                    </span>
                                </div>

                            </div>

                            <div class="usuario-acoes d-flex gap-2">

                                <button
                                    type="button"
                                    class="btn btn-sm <?php echo !empty($u['segue']) ? 'btn-secondary' : 'btn-primary'; ?> btn-seguir"
                                    onclick="seguirUsuario(<?php echo (int) $u['id']; ?>, this)"
                                >
                                    <?php echo !empty($u['segue']) ? 'Deixar de Seguir' : 'Seguir'; ?>
                                </button>

                                <a
                                    href="<?php echo url('/usuario?id=' . (int) $u['id']); ?>"
                                    class="btn btn-sm btn-outline-dark"
                                >
                                    Ver Perfil
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>

<?php require_once "app/views/layouts/footer.php"; ?>
