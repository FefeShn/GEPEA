<?php
session_start();
require '../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

$pdo = getConexao();
$pdo->exec("CREATE TABLE IF NOT EXISTS evento (
  id_evento INT AUTO_INCREMENT PRIMARY KEY,
  titulo_evento VARCHAR(255) NOT NULL,
  conteudo_evento TEXT NOT NULL,
  data_evento DATETIME NOT NULL,
  foto_evento VARCHAR(512) DEFAULT NULL,
  id_usuario INT NOT NULL
)");
$pdo->exec("CREATE TABLE IF NOT EXISTS evento_imagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  evento_id INT NOT NULL,
  caminho VARCHAR(512) NOT NULL,
  ordem INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (evento_id) REFERENCES evento(id_evento) ON DELETE CASCADE
)");

// Buscar eventos mais recentes
$stmt = $pdo->query("SELECT id_evento, titulo_evento, conteudo_evento, foto_evento, data_evento FROM evento ORDER BY id_evento DESC");
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginaAtiva = 'eventos-admin'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
<?php
require '../include/navbar.php';
require '../include/menu-admin.php';
?>
  <div class="container-scroller">

      <!-- CONTEÚDO PRINCIPAL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <div class="titulo-publicacoes"> 
                    <h3 class="font-weight-bold">Eventos</h3>
                    <h6 class="font-weight-normal mb-0">Últimos eventos do grupo</h6>
                    <div class="acoes-publicacoes">
                        <button class="btn btn-adicionar">
                            <i class="ti-plus"></i> Novo Evento
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
            <?php if (empty($eventos)): ?>
              <div class="col-12"><p>Nenhum evento cadastrado ainda. Clique em "Novo Evento" para começar.</p></div>
            <?php else: ?>
              <?php foreach ($eventos as $ev): 
                $id = (int)$ev['id_evento'];
                $titulo = htmlspecialchars($ev['titulo_evento'] ?? '');
                // trecho do conteúdo como resumo
                $resumo = htmlspecialchars(mb_strimwidth(strip_tags($ev['conteudo_evento'] ?? ''), 0, 140, '...'));
                $img = htmlspecialchars($ev['foto_evento'] ?? '../imagens/emoji.png');
                $dataFmt = htmlspecialchars(date('d/m/Y', strtotime($ev['data_evento'])));
                $fileRel = '../eventos/evento' . $id . '.php';
                $fileAbs = __DIR__ . '/../eventos/evento' . $id . '.php';
                $href = is_file($fileAbs) ? $fileRel : ('./editar-evento.php?id=' . $id);
              ?>
              <div class="col-md-4 mb-4 sombra-transparente">
                <div class="card h-100">
                  <img src="<?= $img ?>" class="card-img-top" alt="foto do evento">
                  <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <small class="text-muted"><?= $dataFmt ?></small>
                    </div>
                    <h5 class="card-title"><?= $titulo ?></h5>
                    <p class="card-text"><?= $resumo ?></p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                      <a href="<?= $href ?>" class="btn btn-success">Ver detalhes</a>
                    </div>
                  </div>
                </div>
                <input type="checkbox" class="publi-checkbox" value="<?= $id ?>">
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <!-- Modal de Adicionar Evento -->
          <div class="modal-publicacao-overlay" id="modalEvento">
            <div class="modal-publicacao-container">
              <div class="modal-publicacao-header">
                <h3>Novo Evento</h3>
                <button class="modal-publicacao-close">&times;</button>
              </div>
              <div class="modal-publicacao-content">
                <form id="formEvento" method="post" enctype="multipart/form-data">
                  <div class="form-group-publicacao">
                    <label for="tituloEvento">Título</label>
                    <input type="text" id="tituloEvento" name="tituloEvento" placeholder="Digite o título do evento" required>
                  </div>
                  <div class="form-group-publicacao">
                    <label for="resumoEvento">Texto do evento</label>
                    <textarea id="resumoEvento" name="resumoEvento" placeholder="Informe o texto do evento" required></textarea>
                  </div>
                  <div class="form-group-publicacao">
                    <label for="imagemEvento">Imagem</label>
                    <input type="file" id="imagemEvento" name="imagemEvento" accept="image/*">
                    <label for="imagemEvento" class="file-upload-label">
                      <i class="ti-image mr-2"></i>Selecione uma imagem
                    </label>
                  </div>
                  <div class="data-atual-publicacao">
                    Data do evento: <span id="dataAtualEvento"></span>
                  </div>
                  <div class="modal-publicacao-actions">
                    <button type="button" class="modal-publicacao-cancel">Cancelar</button>
                    <button type="submit" class="modal-publicacao-submit">Criar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal de Confirmação de Exclusão de Eventos -->
          <div class="modal-overlay" id="modalExcluirEvento">
            <div class="modal-container confirm-modal">
              <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
              </div>
              <div class="modal-body">
                <p>Tem certeza que deseja excluir o(s) evento(s) selecionado(s)? Esta ação não pode ser desfeita.</p>
              </div>
              <div class="modal-actions">
                <button class="cancel-button" id="cancelarExclusaoEvento">Não, cancelar</button>
                <button class="submit-button delete-button" id="confirmarExclusaoEvento">Sim, excluir</button>
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