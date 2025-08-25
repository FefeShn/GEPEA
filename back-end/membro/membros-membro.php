<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GEPEA</title>
  <!-- endinject -->
  <link rel="shortcut icon" href="../imagens/gepea.png" />
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  
  <div class="container-scroller">
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
            <div class="input-group-prepend" id="navbar-search-icon">
            
            </div>
            <input type="text" class="form-control busca" id="navbar-search-input" placeholder="Busca" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>

        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <div class="profile-img">
                <a href="biografia-membro.php">
                  <img src="../imagens/estrela.jpg" alt="profile" class="profile-img">
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

      <!-- partial -->
      <!-- MENU LATERAL -->
      <button id="botao-menu" aria-label="Abrir menu">☰</button>
      <nav class="menu-lateral" id="menuLateral">
        <ul>
          <li><a href="index-membro.php"><i class="ti-home mr-2"></i>Publicações</a></li>
          <li><a href="acoes-membro.php"><i class="ti-home mr-2"></i>Ações</a></li>
          <li><a href="sobre-membro.php"><i class="ti-book mr-2"></i>Sobre o GEPEA</a></li>
          <li><a href="membros-membro.php" class="active"><i class="ti-agenda mr-2"></i>Membros</a></li>
          <li><a href="biblioteca.php"><i class="ti-agenda mr-2"></i>Biblioteca</a></li>
          <li><a href="agenda.php"><i class="ti-agenda mr-2"></i>Agenda</a></li>
          <li><a href="forum.php"><i class="ti-agenda mr-2"></i>Fórum</a></li>
          <li><a href="../anonimo/suporte.php"><i class="ti-user mr-2"></i>Suporte</a></li>
        </ul>
      </nav>

      <!-- CONTEÚDO PRINCIPAL -->
      <main class="members-container">
        <h1 class="page-title">Nossos Membros</h1>
        
        <div class="members-grid">
            <!-- Membro 1 -->
            <a href="../biografias/biografia1.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/dino.jpg" alt="Foto do Coordenador">
                </div>
                <h3 class="member-name">Dr. Luciano Corsino</h3>
                <p class="member-role coordenador">Coordenador</p>
            </a>
            
            <!-- Membro 2 -->
            <a href="../biografias/biografia2.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/estrela.jpg" alt="Foto do Vice-Coordenador">
                </div>
                <h3 class="member-name">Dr. Daniel Santana</h3>
                <p class="member-role vice-coordenador">Vice-Coordenador</p>
            </a>
            
            <!-- Membro 3 -->
            <a href="../biografias/biografia3.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/computer.jpg" alt="Foto do Bolsista">
                </div>
                <h3 class="member-name">Fernanda Sehn</h3>
                <p class="member-role bolsista">Bolsista</p>
            </a>
            
            <!-- Membro 4 -->
            <a href="../biografias/biografia4.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/roque.jpg" alt="Foto do Membro">
                </div>
                <h3 class="member-name">Danieri Ribeiro</h3>
                <p class="member-role membro">Membro</p>
            </a>
            
            <!-- Membro 5 -->
            <a href="../biografias/biografia5.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/musga.jpg" alt="Foto do Bolsista">
                </div>
                <h3 class="member-name">Brenda Marins</h3>
                <p class="member-role bolsista">Bolsista</p>
            </a>
            
            <!-- Membro 6 -->
            <a href="../biografias/biografia6.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/abraco.jpg" alt="Foto da Bolsista">
                </div>
                <h3 class="member-name">Deisi Franco</h3>
                <p class="member-role bolsista">Bolsista</p>
            </a>
            
            <!-- Membro 7 -->
            <a href="../biografias/biografia7.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/flori.jpg" alt="Foto do Membro">
                </div>
                <h3 class="member-name">Me. Leandro Nogueira</h3>
                <p class="member-role membro">Membro</p>
            </a>
            
            <!-- Membro 8 -->
            <a href="../biografias/biografia8.php" class="member-card">
                <div class="member-photo">
                    <img src="../imagens/dormino.jpg" alt="Foto da Membro">
                </div>
                <h3 class="member-name">Ma. Myllena Camargo</h3>
                <p class="member-role membro">Membro</p>
            </a>
        </div>
    </main>
        
        <!-- FOOTER -->
        <?php
          require("../include/footer.php");
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>