<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Consider user logged in when there's a valid user id in the session
$isLoggedIn = !empty($_SESSION['id_usuario']);
$fotoPerfil = "../imagens/user-foto.png";
if ($isLoggedIn) {
  $sessFoto = $_SESSION['foto_user'] ?? '';
  if (is_string($sessFoto) && trim($sessFoto) !== '') {
    $fotoPerfil = $sessFoto;
  }
}
$nomeUsuario = $isLoggedIn ? ($_SESSION['nome_user'] ?? 'Usuário') : 'Visitante';
?>

<!-- NAV BAR -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a href="<?php echo $isLoggedIn ? (($_SESSION['eh_adm'] ?? false) ? '../admin/index-admin.php' : '../membro/index-membro.php') : '../anonimo/index.php'; ?>">
      <img src="../imagens/gepea.png" alt="logo-gepea" class="logo-nav">
    </a>
    <p class="titulo-logo">GEPEA</p>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">
        <div class="input-group busca-box">
          <div class="input-group-prepend" id="navbar-search-icon"></div>
          <input type="text" class="form-control busca" id="navbar-search-input" placeholder="Busca" aria-label="search" aria-describedby="search">
        </div>
      </li>
    </ul>

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <?php if (!$isLoggedIn): ?>
          <a class="nav-link" href="../anonimo/login.php">
            <div class="profile-img-container">
              <img src="<?= htmlspecialchars($fotoPerfil) ?>" alt="profile" class="profile-img">
            </div>
          </a>
        <?php else: ?>
          <div class="profile-dropdown-wrapper">
            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <div class="profile-img-container">
                <img src="<?= htmlspecialchars($fotoPerfil) ?>" alt="profile" class="profile-img">
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown profile-dropdown-menu" aria-labelledby="profileDropdown">
              <span class="dropdown-item user-highlight">
                <i class="ti-user text-primary"></i>
                <?= htmlspecialchars($nomeUsuario) ?>
              </span>
              <a class="dropdown-item" href="<?php echo ($_SESSION['eh_adm'] ?? false)
                ? '../admin/biografia-admin.php'
                : ('../membro/perfil.php?id=' . urlencode((string)($_SESSION['id_usuario'] ?? ''))); ?>">
                <i class="ti-id-badge text-primary"></i>
                Ir para o perfil
              </a>
              <a class="dropdown-item" href="#" id="logout-btn">
                <i class="ti-power-off text-primary"></i>
                Desconectar
              </a>
            </div>
          </div>
        <?php endif; ?>
      </li>
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>
<!-- FIM DA NAV BAR -->