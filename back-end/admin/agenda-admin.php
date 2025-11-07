<?php
$paginaAtiva = 'agenda-admin'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
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
              <div class="acoes-publicacoes">
                <button class="btn btn-adicionar" id="adicionarEvento">
                  <i class="ti-plus"></i> Registrar Novo Evento
                </button>
                <button class="btn btn-excluir" id="excluirAtividade">
                  <i class="ti-trash"></i> Excluir Atividade
                </button>
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

      <!-- Modal de Evento-->
      <div id="modalEvento" class="modal-evento-overlay">
        <div class="modal-evento-container">
          <div class="modal-evento-header">
            <h3 id="modalEventoTitulo">Novo Evento</h3>
            <button class="modal-evento-close">&times;</button>
          </div>
          <div class="modal-evento-content">
            <form id="formEvento">
              <div class="form-group">
                <label for="tituloEvento">Título</label>
                <input type="text" id="tituloEvento" required>
              </div>
              <div class="form-group">
                <label for="dataInicio">Início</label>
                <input type="datetime-local" id="dataInicio" required>
              </div>
              <div class="form-group">
                <label for="dataFim">Fim</label>
                <input type="datetime-local" id="dataFim">
              </div>
              <div class="form-group">
                <label for="corEvento">Cor</label>
                <select id="corEvento">
                  <option value="">Padrão</option>
                  <option value="important">Vermelho</option>
                  <option value="info">Azul</option>
                  <option value="success">Verde</option>
                  <option value="warning">Amarelo</option>
                  <option value="rosa">Rosa</option>
                  <option value="roxo">Roxo</option>
                </select>
              </div>
              <div class="modal-evento-actions">
                <button type="button" class="btn btn-cancelar">Cancelar</button>
                <button type="submit" class="btn btn-salvar">Salvar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Modal Excluir Atividades -->
      <div class="modal-overlay" id="modalExcluirAtividade" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="modal-container confirm-modal">
          <div class="modal-header">
            <h3>Excluir Atividades</h3>
            <button class="modal-close" aria-label="Fechar modal">&times;</button>
          </div>
          <div class="modal-body">
            <p>Selecione as atividades que deseja excluir:</p>
            <div id="listaAtividades" style="max-height:320px; overflow:auto; margin-top:10px;"></div>
          </div>
          <div class="modal-actions">
            <button class="btn btn-secondary" id="cancelarExclusaoAtividade">Cancelar</button>
            <button class="btn btn-danger" id="confirmarExclusaoAtividade">Excluir Selecionadas</button>
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