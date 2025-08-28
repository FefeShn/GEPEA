<?php
// Define valores padrão caso não tenham sido setados
$fotoPerfil = $fotoPerfil ?? "../imagens/user-foto.png";
$linkPerfil = $linkPerfil ?? "login.php"; 
?>

<!-- NAV BAR -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <img src="../imagens/gepea.png" alt="logo-gepea" class="logo-nav">
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
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
          <div class="profile-img">
            <a href="<?= $linkPerfil ?>">
              <img src="<?= $fotoPerfil ?>" alt="profile" class="profile-img">
            </a>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item">
            <i class="ti-settings text-primary"></i>
            Configurações
          </a>
          <a class="dropdown-item" id="logout-btn">
            <i class="ti-power-off text-primary"></i>
            Sair
          </a>
        </div>
      </li>
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>
<!-- FIM DA NAV BAR -->
