<?php
$paginaAtiva = 'acoes-admin'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
  
  <div class="container-scroller">>

      <!-- CONTEÚDO PRINCIPAL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <div class="titulo-publicacoes"> 
                    <h3 class="font-weight-bold">Ações</h3>
                    <h6 class="font-weight-normal mb-0">Últimas ações do grupo</h6>
                    <div class="acoes-publicacoes">
                        <button class="btn btn-adicionar">
                            <i class="ti-plus"></i> Publicar nova ação
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
                <img src="../imagens/artigo2.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">26/06/2025</small>
                  </div>
                  <h5 class="card-title">Artigo Publicado: Implementação da Lei nº 10.639/03 na Educação Básica: contribuições do campo da educação física escolar</h5>
                  <p class="card-text">Artigo publicado na Revista Caderno Pedagógico</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../acoes/acao1.php" class="btn btn-success">Ver detalhes</a>
                    
                  </div>
                </div>
              </div>
              <input type="checkbox" class="publi-checkbox">
            </div>

            <!-- Card 2 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/artigo1.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">22/04/2025</small>
                  </div>
                  <h5 class="card-title">Artigo Publicado: Não basta não ser racista, é preciso ser antirracista: uma revisão sistemática sobre educação física escolar</h5>
                  <p class="card-text">Artigo publicado na revista Boletim de Conjuntura (BOCA)</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../acoes/acao2.php" class="btn btn-success">Ver detalhes</a>
                  </div>
                </div>
              </div>
              <input type="checkbox" class="publi-checkbox">
            </div>

            <!-- Card 3 -->
            <div class="col-md-4 mb-4 sombra-transparente">
              <div class="card h-100">
                <img src="../imagens/bento.jpeg" class="card-img-top" alt="foto do post">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">05/12/2024</small>
                  </div>
                  <h5 class="card-title">GEPEA presente no Salão de Bento Gonçalves</h5>
                  <p class="card-text">Bolsistas apresentaram seus projetos no evento.</p>
                  <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="../acoes/acao3.php" class="btn btn-success">Ver detalhes</a>
                  </div>
                </div>
              </div>
            <input type="checkbox" class="publi-checkbox">
            </div>
          </div>
            <!-- Modal Nova Ação -->
          <div id="modalNovaAcao" class="modal-overlay">
            <div class="modal-container">
              <div class="modal-header">
                <h3>Nova Ação</h3>
                <button class="modal-acao-close">&times;</button>
              </div>
              <div class="modal-body">
                <form id="formAcao">
                  <div class="form-group">
                    <label for="tituloAcao">Título da Ação</label>
                    <input type="text" id="tituloAcao" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="descricaoAcao">Descrição</label>
                    <textarea id="descricaoAcao" class="form-control" rows="4" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="imagemAcao" class="file-upload-btn">
                      <i class="ti-image mr-2"></i>Selecione uma imagem
                      <input type="file" id="imagemAcao" accept="image/*">
                    </label>
                  </div>
                  <div class="form-group">
                    <label>Data de Publicação</label>
                    <div id="dataAtualAcao" class="form-control-static"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-acao-cancel">Cancelar</button>
                    <button type="submit" class="btn btn-primary publicar-acao">Publicar Ação</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

  <!-- Modal Excluir Ação -->
          <div id="modalExcluirAcao" class="modal-overlay">
            <div class="modal-container">
              <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button class="close-modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>Tem certeza que deseja excluir a(s) ação(ões) selecionada(s)?</p>
              </div>
              <div class="modal-footer">
                <button type="button" id="cancelarExclusaoAcao" class="btn btn-secondary cancelar">Cancelar</button>
                <button type="button" id="confirmarExclusaoAcao" class="btn btn-danger excluir-acao">Excluir</button>
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

</html>