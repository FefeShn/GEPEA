<?php
// Sessão e proteção admin
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

// DB
$pdo = getConexao();
$stmt = $pdo->query("SELECT id_arquivo, nome_arquivo, descricao_arquivo, url_arquivo, tipo_arquivo, tamanho_arquivo, data_upload FROM arquivo ORDER BY id_arquivo DESC");
$arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$paginaAtiva = 'biblioteca-admin'; 
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
    <main class="library-container">
      <div class="library-header">
        <h1 class="page-title">Biblioteca</h1>
        <div class="library-actions">
            <button id="openUploadModal" class="add-file-button">
                Upload de Arquivo
            </button>
            <button id="openDeleteModal" class="delete-file-button">
                Excluir Arquivo
            </button>
        </div>
        <p class="page-subtitle">Materiais disponíveis para download e acesso</p>
      
      <div class="library-grid">
        <?php if (empty($arquivos)): ?>
          <p>Nenhum arquivo enviado ainda. Clique em "Upload de Arquivo" para começar.</p>
        <?php else: ?>
          <?php foreach ($arquivos as $arq): 
            $id = (int)$arq['id_arquivo'];
            $titulo = htmlspecialchars($arq['nome_arquivo'] ?? 'Arquivo');
            $desc = htmlspecialchars($arq['descricao_arquivo'] ?? '');
            $data = htmlspecialchars(date('d/m/Y', strtotime($arq['data_upload'])));
            $url = (string)($arq['url_arquivo'] ?? '');
            $isLink = preg_match('#^https?://#i', $url) || ($arq['tipo_arquivo'] ?? '') === 'link';
            $downloadHref = $isLink ? htmlspecialchars($url) : ('./api/arquivo_download.php?id=' . $id);
            $ext = $isLink ? 'link' : strtolower(pathinfo($url, PATHINFO_EXTENSION));
            $tam = (int)($arq['tamanho_arquivo'] ?? 0);
            $tamFmt = $tam > 0 ? ( $tam >= 1048576 ? number_format($tam/1048576, 2, ',', '.') . ' MB' : number_format($tam/1024, 0, ',', '.') . ' KB') : '';
          ?>
          <div class="document-card">
            <div class="document-info document-content">
              <h3><?= $titulo ?></h3>
              <p class="document-filename">
                <?php if ($isLink): ?>
                  Link (<?= parse_url($url, PHP_URL_HOST) ?>)
                <?php else: ?>
                  <?= htmlspecialchars(basename($url)) ?> <?= $ext ? '(' . $ext . ')' : '' ?> <?= $tamFmt ? '· ' . $tamFmt : '' ?>
                <?php endif; ?>
              </p>
              <?php if ($desc !== ''): ?><p class="document-description"><?= $desc ?></p><?php endif; ?>
              <p class="document-date">Postado em: <?= $data ?></p>
            </div>
            <a href="<?= $downloadHref ?>" class="download-button" <?= $isLink ? 'target="_blank" rel="noopener"' : '' ?>>
              <i class="ti ti-download"></i> <?= $isLink ? 'Acessar' : 'Baixar' ?>
            </a>
            <input type="checkbox" class="file-checkbox" value="<?= $id ?>">
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </main>
    <!-- Modal de Upload -->
<div class="modal-overlay" id="modalUpload">
  <div class="modal-container">
    <div class="modal-header">
      <h3>Upload de Arquivo</h3>
      <button class="close-modal">&times;</button>
    </div>
    <div class="modal-body">
      <form id="uploadForm" enctype="multipart/form-data">
        <div class="form-group">
          <label>Tipo de envio</label>
          <div class="upload-type-row">
            <label class="tipo-label"><input type="radio" name="tipo" value="arquivo" checked> Arquivo</label>
            <label class="tipo-label"><input type="radio" name="tipo" value="link"> Link</label>
          </div>
        </div>
        <div class="form-group">
          <label for="fileTitle">Título do Arquivo</label>
          <input type="text" id="fileTitle" name="titulo" placeholder="Ex: Fighting Words - Patricia Hill Collins" required>
        </div>
        <div class="form-group">
          <label for="fileDescription">Descrição</label>
          <textarea id="fileDescription" name="descricao" rows="3" placeholder="Descreva o conteúdo do arquivo..."></textarea>
        </div>
        <div class="form-group group-arquivo">
          <label for="fileUpload">Selecione o arquivo</label>
          <input type="file" id="fileUpload" name="arquivo" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif,.webp,.csv,.zip,.rar,.7z" required>
        </div>
        <div class="form-group group-link" style="display:none;">
          <label for="linkUrl">Cole o link</label>
          <input type="url" id="linkUrl" name="link_url" placeholder="https://...">
        </div>
        <div class="modal-actions">
          <button type="button" class="cancel-button">Cancelar</button>
          <button type="submit" class="submit-button">Enviar Arquivo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
    <div class="modal-overlay" id="modalExcluirMembro" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalExcluirTitle">
    <div class="modal-container confirm-modal">
        <div class="modal-header">
            <h3 id="modalExcluirTitle">Confirmar Exclusão</h3>
            <button class="modal-close" aria-label="Fechar modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Tem certeza que deseja excluir o(s) arquivo(s) selecionado(s)? Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" id="cancelarExclusao">Não, cancelar</button>
            <button class="btn btn-danger" id="confirmarExclusao">Sim, excluir</button>
        </div>
    </div>
</div>
    <!-- FOOTER-->
     <?php
      include"../include/footer.php";
     ?>
      </div>
  </div>
  <script src="../script.js"></script>
</body>
</html>