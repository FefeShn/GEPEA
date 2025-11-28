<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<nav id="menuLateral" class="menu-lateral">
  <ul>
    <li><a href="../admin/index-admin.php" class="nav-link">Início</a></li>
    <li><a href="../admin/eventos-admin.php" class="nav-link">Eventos</a></li>
    <li><a href="../admin/sobre-admin.php" class="nav-link">Sobre</a></li>
    <li><a href="../admin/membros-admin.php" class="nav-link">Membros</a></li>
    <li><a href="../admin/biblioteca-admin.php" class="nav-link">Biblioteca</a></li>
    <li><a href="../admin/agenda-admin.php" class="nav-link">Agenda</a></li>
    <li><a href="../admin/forum-admin.php" class="nav-link">Bate-papos</a></li>
    <li><a href="../anonimo/suporte.php" class="nav-link">Suporte</a></li>
  </ul>
</nav>