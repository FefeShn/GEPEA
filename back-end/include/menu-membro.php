<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<nav id="menuLateral" class="menu-lateral">
  <ul>
    <li><a href="../membro/index-membro.php" class="nav-link">Início</a></li>
    <li><a href="../membro/eventos-membro.php" class="nav-link">Eventos</a></li>
    <li><a href="../membro/sobre-membro.php" class="nav-link">Sobre</a></li>
    <li><a href="../membro/membros-membro.php" class="nav-link">Membros</a></li>
    <li><a href="../membro/biblioteca.php" class="nav-link">Biblioteca</a></li>
    <li><a href="../membro/agenda.php" class="nav-link">Agenda</a></li>
    <li><a href="../membro/forum.php" class="nav-link">Bate-papos</a></li>
    <li><a href="../anonimo/suporte.php" class="nav-link">Suporte</a></li>
  </ul>
</nav>