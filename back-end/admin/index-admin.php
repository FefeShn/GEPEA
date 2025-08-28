<?php
$paginaAtiva = 'index'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>

<body>

  <div class="container-scroller">
      <!-- CONTEÚDO PRINCIPAL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <div class="titulo-publicacoes"> 
                    <h3 class="font-weight-bold">Publicações</h3>
                    <h6 class="font-weight-normal mb-0">Últimas atualizações do grupo</h6>
                    <div class="acoes-publicacoes">
                        <button class="btn btn-adicionar">
                            <i class="ti-plus"></i> Nova Publicação
                        </button>
                        <button class="btn btn-excluir">
                            <i class="ti-trash"></i> Excluir
                        </button>
                    </div>
                </div>
                </div>

              </div>
            </div>
          </div>

          <div class="row" id="publicacoes-container">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/reuniaogepea.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">13/03/2025</small>
                  </div>
                  <h5 class="card-title">Reunião de Leitura</h5>
                  <p class="card-text">Reunião de leitura para discutir o capítulo do livro "Pensamento Feminista Negro", de Patricia Hill Collins.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../publicacoes/publicacao1.php" class="btn btn-success">Ver detalhes</a>

                  </div>
                </div>
              </div>
              <input type="checkbox" class="publi-checkbox">
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/showgepea.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">10/03/2025</small>
                  </div>
                  <h5 class="card-title">Inauguração de Espaços Afrocentrados</h5>
                  <p class="card-text">Evento de inauguração que contou com a presença de artistas locais.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../publicacoes/publicacao2.php" class="btn btn-success">Ver detalhes</a>
                  </div>
                </div>
              </div>
              <input type="checkbox" class="publi-checkbox">
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/gepeaalvorada.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">25/03/2025</small>
                  </div>
                  <h5 class="card-title">Reunião presencial em Alvorada</h5>
                  <p class="card-text">Membros do GEPEA e bolsistas do grupo se reuniram em Alvorada para planejar próximos passos.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../publicacoes/publicacao3.php" class="btn btn-success">Ver detalhes</a>
                  </div>
                </div>
              </div>
              <input type="checkbox" class="publi-checkbox">
            </div>
          </div>

          <!-- Modal de Adicionar Publicação -->
          <div class="modal-publicacao-overlay" id="modalPublicacao">
            <div class="modal-publicacao-container">
              <div class="modal-publicacao-header">
                <h3>Nova Publicação</h3>
                <button class="modal-publicacao-close">&times;</button>
              </div>
              <div class="modal-publicacao-content">
                <form id="formPublicacao">
                  <div class="form-group-publicacao">
                    <label for="tituloPublicacao">Título</label>
                    <input type="text" id="tituloPublicacao" placeholder="Digite o título da publicação" required>
                  </div>
        
                  <div class="form-group-publicacao">
                    <label for="resumoPublicacao">Resumo</label>
                    <textarea id="resumoPublicacao" placeholder="Digite um resumo da publicação" required></textarea>
                  </div>
        
                  <div class="form-group-publicacao">
                    <label for="imagemPublicacao">Imagem</label>
                    <input type="file" id="imagemPublicacao" accept="image/*">
                    <label for="imagemPublicacao" class="file-upload-label">
                      <i class="ti-image mr-2"></i>Selecione uma imagem
                    </label>
                  </div>
        
                  <div class="data-atual-publicacao">
                    Data da publicação: <span id="dataAtual"></span>
                  </div>
        
                  <div class="modal-publicacao-actions">
                    <button type="button" class="modal-publicacao-cancel">Cancelar</button>
                    <button type="submit" class="modal-publicacao-submit">Publicar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal de Confirmação de Exclusão de Publicações -->
          <div class="modal-overlay" id="modalExcluirPublicacao">
            <div class="modal-container confirm-modal">
              <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
              </div>
              <div class="modal-body">
                <p>Tem certeza que deseja excluir a(s) publicação(ões) selecionada(s)? Esta ação não pode ser desfeita.</p>
              </div>
              <div class="modal-actions">
                <button class="cancel-button" id="cancelarExclusaoPubli">Não, cancelar</button>
                <button class="submit-button delete-button" id="confirmarExclusaoPubli">Sim, excluir</button>
              </div>
            </div>
          </div>
          
        <!-- FOOTER -->
        <?php
          include"../include/footer.php";
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>
