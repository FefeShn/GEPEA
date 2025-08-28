<?php
$paginaAtiva = 'agenda'; 
$fotoPerfil  = "../imagens/estrela.jpg"; 
$linkPerfil  = "../membro/biografia-membro.php"; 
require '../include/navbar.php';
require '../include/menu-membro.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<!-- FullCalendar CSS -->
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet' media='print' />

<body>
  <div class="container-scroller">
    
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
        include"../include/footer.php";
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