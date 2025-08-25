<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GEPEA</title>
  <link rel="shortcut icon" href="../imagens/gepea.png" />
  <link rel="stylesheet" href="../style.css">
  <!-- FullCalendar CSS -->
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
  <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet' media='print' />
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

    <!-- MENU LATERAL -->
    <button id="botao-menu" aria-label="Abrir menu">☰</button>
    <nav class="menu-lateral" id="menuLateral">
      <ul>
        <li><a href="index-membro.php"><i class="ti-home mr-2"></i>Publicações</a></li>
        <li><a href="acoes-membro.php"><i class="ti-home mr-2"></i>Ações</a></li>
        <li><a href="sobre-membro.php"><i class="ti-book mr-2"></i>Sobre o GEPEA</a></li>
        <li><a href="membros-membro.php"><i class="ti-agenda mr-2"></i>Membros</a></li>
        <li><a href="biblioteca.php"><i class="ti-agenda mr-2"></i>Biblioteca</a></li>
        <li><a href="agenda.php" class="active"><i class="ti-agenda mr-2"></i>Agenda</a></li>
        <li><a href="forum.php"><i class="ti-agenda mr-2"></i>Fórum</a></li>
        <li><a href="../anonimo/suporte.php"><i class="ti-user mr-2"></i>Suporte</a></li>
      </ul>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between align-items-center">
              <div class="titulo-publicacoes">
                <h3 class="font-weight-bold">Agenda</h3>
                <h6 class="font-weight-normal mb-0">Eventos e compromissos do grupo</h6>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div id="calendar"></div>
          </div>
        </div>
      </div>

      <!-- Modal de Evento para Membros (só visualização e presença) -->
      <div id="modalEvento" class="modal-evento-overlay">
        <div class="modal-evento-container">
          <div class="modal-evento-header">
            <h3 id="modalEventoTitulo">Detalhes do Evento</h3>
            <button class="modal-evento-close">&times;</button>
          </div>
          <div class="modal-evento-content">
            <div class="evento-info">
              <p><strong>Título:</strong> <span id="evento-titulo"></span></p>
              <p><strong>Data:</strong> <span id="evento-data"></span></p>
              <p><strong>Horário:</strong> <span id="evento-horario"></span></p>
            </div>
            <div class="presenca-status" id="presenca-status">
              <p>Status de presença: <span id="status-text">Não informado</span></p>
            </div>
            <div class="presenca-botoes">
                <button class="btn-presenca btn-marcar-ausente" id="btn-ausente">Não poderei comparecer</button>
              <button class="btn-presenca btn-marcar-presenca" id="btn-presente">Marcar Presença</button>
            </div>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <?php
        require("../include/footer.php");
      ?>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/pt-br.js"></script>
  <script src="../script.js"></script>
</body>
</html>