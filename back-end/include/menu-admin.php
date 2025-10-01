<!-- MENU LATERAL ADMIN -->
<?php
$paginaAtiva = $paginaAtiva ?? 'index-admin';
?>
<button id="botao-menu" aria-label="Abrir menu">☰</button>
<nav class="menu-lateral" id="menuLateral">
  <ul>
    <li><a href="../admin/index-admin.php" class="<?= ($paginaAtiva === 'index-admin') ? 'active' : '' ?>"><i class="ti-home mr-2"></i>Publicações</a></li>
    <li><a href="../admin/eventos-admin.php" class="<?= ($paginaAtiva === 'eventos-admin') ? 'active' : '' ?>"><i class="ti-home mr-2"></i>Eventos</a></li>
    <li><a href="../admin/sobre-admin.php" class="<?= ($paginaAtiva === 'sobre-admin') ? 'active' : '' ?>"><i class="ti-book mr-2"></i>Sobre o GEPEA</a></li>
    <li><a href="../admin/membros-admin.php" class="<?= ($paginaAtiva === 'membros-admin') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Membros</a></li>
    <li><a href="../admin/biblioteca-admin.php" class="<?= ($paginaAtiva === 'biblioteca-admin') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Biblioteca</a></li>
    <li><a href="../admin/agenda-admin.php" class="<?= ($paginaAtiva === 'agenda-admin') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Agenda</a></li>
    <li><a href="../admin/forum-admin.php" class="<?= ($paginaAtiva === 'forum-admin') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Fórum</a></li>
    <li><a href="../anonimo/suporte.php" class="<?= ($paginaAtiva === 'suporte') ? 'active' : '' ?>"><i class="ti-user mr-2"></i>Suporte</a></li>
  </ul>
</nav>
