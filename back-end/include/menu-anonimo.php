<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<nav id="menuLateral" class="menu-lateral">
  <ul>
    <li><a href="../anonimo/index.php" class="nav-link">Início</a></li>
    <li><a href="../anonimo/eventos.php" class="nav-link">Eventos</a></li>
    <li><a href="../anonimo/sobre.php" class="nav-link">Sobre</a></li>
    <li><a href="../anonimo/membros.php" class="nav-link">Membros</a></li>
    <li><a href="../anonimo/suporte.php" class="nav-link">Suporte</a></li>
  </ul>
</nav>