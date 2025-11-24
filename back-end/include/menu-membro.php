<!-- MENU LATERAL -->
<?php
$paginaAtiva = $paginaAtiva ?? 'index-membro';
?>
<button id="botao-menu" aria-label="Abrir menu">☰</button>
<nav class="menu-lateral" id="menuLateral">
  <ul>
    <li><a href="../membro/index-membro.php" class="<?= ($paginaAtiva === 'index-membro') ? 'active' : '' ?>"><i class="ti-home mr-2"></i>Publicações</a></li>
    <li><a href="../membro/eventos-membro.php" class="<?= ($paginaAtiva === 'eventos-membro') ? 'active' : '' ?>"><i class="ti-home mr-2"></i>Eventos</a></li>
    <li><a href="../membro/sobre-membro.php" class="<?= ($paginaAtiva === 'sobre-membro') ? 'active' : '' ?>"><i class="ti-book mr-2"></i>Sobre o GEPEA</a></li>
    <li><a href="../membro/membros-membro.php" class="<?= ($paginaAtiva === 'membros-membro') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Membros</a></li>
    <li><a href="../membro/biblioteca.php" class="<?= ($paginaAtiva === 'biblioteca') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Biblioteca</a></li>
    <li><a href="../membro/agenda.php" class="<?= ($paginaAtiva === 'agenda') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Agenda</a></li>
    <li><a href="../membro/forum.php" class="<?= ($paginaAtiva === 'forum') ? 'active' : '' ?>"><i class="ti-agenda mr-2"></i>Bate-papo</a></li>
    <li><a href="../anonimo/suporte.php" class="<?= ($paginaAtiva === 'suporte') ? 'active' : '' ?>"><i class="ti-user mr-2"></i>Suporte</a></li>
  </ul>
</nav>
