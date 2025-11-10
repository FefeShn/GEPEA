<?php
$paginaAtiva = 'biblioteca'; 
$fotoPerfil  = "../imagens/estrela.jpg"; 
$linkPerfil  = "../membro/biografia-membro.php"; 
require '../include/navbar.php';
require '../include/menu-membro.php';

// Conexão com o banco e carregamento de arquivos da biblioteca (mesma fonte do admin)
require_once __DIR__ . '/../config/conexao.php';
$pdo = getConexao();
$stmt = $pdo->query("SELECT id_arquivo, nome_arquivo, descricao_arquivo, url_arquivo, tipo_arquivo, tamanho_arquivo, data_upload FROM arquivo ORDER BY id_arquivo DESC");
$arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
function h($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
  <div class="container-scroller">
    
    <!-- CONTEÚDO PRINCIPAL -->
    <main class="library-container">
      <div class="library-header">
        <h1 class="page-title">Biblioteca</h1>
        <p class="page-subtitle">Materiais disponíveis para download</p>
      </div>
      
      <div class="library-grid">
        <?php if (empty($arquivos)): ?>
          <p>Nenhum arquivo disponível no momento.</p>
        <?php else: ?>
          <?php foreach ($arquivos as $arq): 
            $id = (int)$arq['id_arquivo'];
            $titulo = h($arq['nome_arquivo'] ?? 'Arquivo');
            $desc = h($arq['descricao_arquivo'] ?? '');
            $data = h(date('d/m/Y', strtotime($arq['data_upload'])));
            $url = (string)($arq['url_arquivo'] ?? '');
            $isLink = preg_match('#^https?://#i', $url) || (($arq['tipo_arquivo'] ?? '') === 'link');
            $downloadHref = $isLink ? h($url) : ('../admin/api/arquivo_download.php?id=' . $id);
            $ext = $isLink ? 'link' : strtolower(pathinfo($url, PATHINFO_EXTENSION));
            $tam = (int)($arq['tamanho_arquivo'] ?? 0);
            $tamFmt = $tam > 0 ? ( $tam >= 1048576 ? number_format($tam/1048576, 2, ',', '.') . ' MB' : number_format($tam/1024, 0, ',', '.') . ' KB') : '';
          ?>
          <div class="document-card">
            <div class="document-info document-content">
              <h3><?= $titulo ?></h3>
              <p class="document-filename">
                <?php if ($isLink): ?>
                  Link (<?= h(parse_url($url, PHP_URL_HOST) ?: 'externo') ?>)
                <?php else: ?>
                  <?= h(basename($url)) ?> <?= $ext ? '(' . h($ext) . ')' : '' ?> <?= $tamFmt ? '· ' . h($tamFmt) : '' ?>
                <?php endif; ?>
              </p>
              <?php if ($desc !== ''): ?><p class="document-description"><?= $desc ?></p><?php endif; ?>
              <p class="document-date">Postado em: <?= $data ?></p>
            </div>
            <a href="<?= $downloadHref ?>" class="download-button" <?= $isLink ? 'target="_blank" rel="noopener"' : '' ?> <?= $isLink ? '' : 'download' ?>>
              <i class="ti ti-download"></i> <?= $isLink ? 'Acessar' : 'Baixar' ?>
            </a>
          </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </main>

    <!-- FOOTER-->
     <?php
      include"../include/footer.php";
     ?>
      </div>
  </div>
  <script src="../script.js"></script>
</body>
</html>