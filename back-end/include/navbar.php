<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determina o prefixo correto para links e caminhos de recursos
$scriptDir = dirname($_SERVER['PHP_SELF'] ?? '');
$scriptDir = str_replace('\\', '/', $scriptDir);
$prefix = '../';
if (preg_match('#/back-end$#', $scriptDir)) {
  $prefix = './';
} elseif (preg_match('#/back-end/[^/]+$#', $scriptDir)) {
  $prefix = '../';
}


$isLoggedIn = !empty($_SESSION['id_usuario']);

// Normaliza caminho da foto do perfil para a página atual
function resolveRelPath(string $p, string $prefix): string {
  $p = trim($p);
  if ($p === '') return $prefix . 'imagens/user-foto.png';
  if (preg_match('#^(https?:)?//#', $p) || substr($p,0,1) === '/') return $p;
  if (strpos($p, '../') === 0) return $prefix . ltrim(substr($p, 3), '/');
  if (strpos($p, './') === 0) return $prefix . ltrim(substr($p, 2), '/');
  return $prefix . ltrim($p, '/');
}

// Define a foto de perfil padrão ou do usuário logado
$fotoPerfil = $prefix . 'imagens/user-foto.png';
if ($isLoggedIn) {
  $sessFoto = $_SESSION['foto_user'] ?? '';
  if (is_string($sessFoto) && trim($sessFoto) !== '') {
    $fotoPerfil = resolveRelPath($sessFoto, $prefix);
  }
}
$nomeUsuario = $isLoggedIn ? ($_SESSION['nome_user'] ?? 'Usuário') : 'Visitante';
?>

<!-- NAV BAR -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a href="<?php echo $isLoggedIn ? (($_SESSION['eh_adm'] ?? false) ? ($prefix . 'admin/index-admin.php') : ($prefix . 'membro/index-membro.php')) : ($prefix . 'anonimo/index.php'); ?>">
      <img src="<?= htmlspecialchars($prefix) ?>imagens/gepea.png" alt="logo-gepea" class="logo-nav">
    </a>
    <p class="titulo-logo">GEPEA</p>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button id="botao-menu" type="button" aria-label="Abrir menu">
      <i class="ti-menu"></i>
    </button>
    

    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <?php if (!$isLoggedIn): ?>
          <a class="nav-link" href="<?= htmlspecialchars($prefix) ?>anonimo/login.php">
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
                ? ($prefix . 'admin/biografia-admin.php')
                : ($prefix . 'membro/perfil.php?id=' . urlencode((string)($_SESSION['id_usuario'] ?? ''))); ?>">
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
      <i class="ti-menu"></i>
    </button>
  </div>
</nav>
<!-- FIM DA NAV BAR -->