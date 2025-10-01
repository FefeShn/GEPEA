<!-- MENU LATERAL -->
<?php
$paginaAtiva = $paginaAtiva ?? 'index';
?>
<button id="botao-menu" aria-label="Abrir menu">☰</button>
<nav class="menu-lateral" id="menuLateral">
  <ul>
    <li><a href="../anonimo/index.php" class="<?= ($paginaAtiva === 'index') ? 'active' : '' ?>"><i class="ti-home mr-2"></i>Publicações</a></li>
    <li><a href="../anonimo/eventos.php" class="<?= ($paginaAtiva === 'eventos') ? 'active' : '' ?>"><i class="ti-home mr-2"></i>Eventos</a></li>
    <li><a href="../anonimo/sobre.php" class="<?= ($paginaAtiva === 'sobre') ? 'active' : '' ?>"><i class="ti-book mr-2"></i>Sobre o GEPEA</a></li>
    <li><a href="../anonimo/membros.php" class="<?= ($paginaAtiva === 'membros') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Membros</a></li>
    <li><a href="../anonimo/suporte.php" class="<?= ($paginaAtiva === 'suporte') ? 'active' : '' ?>"><i class="ti-user mr-2"></i>Suporte</a></li>
  </ul>
</nav>
