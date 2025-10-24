<?php
// Iniciar sessão e validar antes de qualquer saída HTML
session_start();
require '../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

// Conexão e tabela
$pdo = getConexao();
$pdo->exec("CREATE TABLE IF NOT EXISTS publicacoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  resumo TEXT,
  imagem VARCHAR(512),
  arquivo VARCHAR(512),
  data_publicacao DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// Buscar publicações
$stmt = $pdo->query("SELECT id, titulo, resumo, imagem, arquivo, data_publicacao FROM publicacoes ORDER BY id DESC");
$publicacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginaAtiva = 'index-admin'; 
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
            <?php if (empty($publicacoes)): ?>
              <div class="col-12"><p>Nenhuma publicação cadastrada ainda. Clique em "Nova Publicação" para começar.</p></div>
            <?php else: ?>
              <?php foreach ($publicacoes as $pub): 
                $id = (int)$pub['id'];
                $titulo = htmlspecialchars($pub['titulo'] ?? '');
                $resumo = htmlspecialchars($pub['resumo'] ?? '');
                $img = htmlspecialchars($pub['imagem'] ?? '../imagens/emoji.png');
                $data = htmlspecialchars(date('d/m/Y', strtotime($pub['data_publicacao'])));
                $arquivo = $pub['arquivo'] ? htmlspecialchars($pub['arquivo']) : ('./editar-publicacao.php?id=' . $id);
              ?>
              <div class="col-md-4 mb-4 sombra-transparente">
                <div class="card h-100">
                  <img src="<?= $img ?>" class="card-img-top" alt="foto do post">
                  <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <small class="text-muted"><?= $data ?></small>
                    </div>
                    <h5 class="card-title"><?= $titulo ?></h5>
                    <p class="card-text"><?= $resumo ?></p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                      <a href="<?= $arquivo ?>" class="btn btn-success">Ver detalhes</a>
                    </div>
                  </div>
                </div>
                <input type="checkbox" class="publi-checkbox" value="<?= $id ?>">
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <!-- Modal de Adicionar Publicação -->
          <div class="modal-publicacao-overlay" id="modalPublicacao">
            <div class="modal-publicacao-container">
              <div class="modal-publicacao-header">
                <h3>Nova Publicação</h3>
                <button class="modal-publicacao-close">&times;</button>
              </div>
              <div class="modal-publicacao-content">
                <form id="formPublicacao" method="post" enctype="multipart/form-data">
                  <div class="form-group-publicacao">
                    <label for="tituloPublicacao">Título</label>
                    <input type="text" id="tituloPublicacao" name="tituloPublicacao" placeholder="Digite o título da publicação" required>
                  </div>
        
                  <div class="form-group-publicacao">
                    <label for="resumoPublicacao">Resumo</label>
                    <textarea id="resumoPublicacao" name="resumoPublicacao" placeholder="Digite um resumo da publicação" required></textarea>
                  </div>
        
                  <div class="form-group-publicacao">
                    <label for="imagemPublicacao">Imagem</label>
                    <input type="file" id="imagemPublicacao" name="imagemPublicacao" accept="image/*">
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
