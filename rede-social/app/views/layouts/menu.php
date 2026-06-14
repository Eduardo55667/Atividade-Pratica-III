<nav class="menu bg-white p-3 shadow-sm d-flex justify-content-around align-items-center mb-4">
    <a href="<?php echo url('/feed'); ?>">
        <i class="bi bi-house-door-fill fs-4 <?php echo ($pagina ?? '') == 'feed' ? 'text-primary' : 'text-secondary'; ?>"></i>
    </a>

    <a href="<?php echo url('/usuarios'); ?>">
        <i class="bi bi-search fs-4 <?php echo ($pagina ?? '') == 'usuarios' ? 'text-primary' : 'text-secondary'; ?>"></i>
    </a>

    <a href="<?php echo url('/perfil'); ?>">
        <i class="bi bi-person-circle fs-4 <?php echo ($pagina ?? '') == 'perfil' ? 'text-primary' : 'text-secondary'; ?>"></i>
    </a>

    <i class="bi bi-moon-stars-fill fs-4 text-secondary" id="btnModo" style="cursor: pointer;"></i>

    <a href="<?php echo url('/sair'); ?>" class="btn btn-outline-danger btn-sm fw-bold">Sair</a>
</nav>

<main class="page-content">
