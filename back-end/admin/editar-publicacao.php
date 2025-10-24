<?php
session_start();
require_once __DIR__ . '/../config/auth.php';
requireAdmin();
require_once __DIR__ . '/../config/conexao.php';

$pdo = getConexao();
$pdo->exec("CREATE TABLE IF NOT EXISTS publicacao_imagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  publicacao_id INT NOT NULL,
  caminho VARCHAR(512) NOT NULL,
  ordem INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (publicacao_id) REFERENCES publicacoes(id) ON DELETE CASCADE
)");
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: ./index-admin.php'); exit; }

$stmt = $pdo->prepare('SELECT * FROM publicacoes WHERE id = ?');
$stmt->execute([$id]);
$pub = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$pub) { header('Location: ./index-admin.php'); exit; }

$erro = '';
// Adicionar imagem extra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'add_imagem') {
  if (isset($_FILES['nova_imagem']) && $_FILES['nova_imagem']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../imagens/publicacoes';
    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0775, true); }
    $tmp = $_FILES['nova_imagem']['tmp_name'];
    $ext = pathinfo($_FILES['nova_imagem']['name'], PATHINFO_EXTENSION);
    $ext = $ext ? ('.' . strtolower($ext)) : '';
    $fileName = 'pub_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $ext;
    $dest = $uploadDir . '/' . $fileName;
    if (move_uploaded_file($tmp, $dest)) {
      // Próxima ordem
      $ord = (int)$pdo->query('SELECT COALESCE(MAX(ordem),0) FROM publicacao_imagens WHERE publicacao_id = ' . $id)->fetchColumn();
      $ord = $ord + 1;
      $imgRel = '../imagens/publicacoes/' . $fileName;
      $ins = $pdo->prepare('INSERT INTO publicacao_imagens (publicacao_id, caminho, ordem) VALUES (?, ?, ?)');
      $ins->execute([$id, $imgRel, $ord]);
      // Se não havia imagem de capa, definir esta como capa
      if (!$pub['imagem']) {
        $updCov = $pdo->prepare('UPDATE publicacoes SET imagem = ? WHERE id = ?');
        $updCov->execute([$imgRel, $id]);
        $pub['imagem'] = $imgRel;
      }
    } else {
      $erro = 'Falha ao enviar a nova imagem.';
    }
  } else {
    $erro = 'Selecione uma imagem válida.';
  }
  // Recarregar dados atualizados
  $stmt = $pdo->prepare('SELECT * FROM publicacoes WHERE id = ?');
  $stmt->execute([$id]);
  $pub = $stmt->fetch(PDO::FETCH_ASSOC) ?: $pub;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['acao'] ?? '') !== 'add_imagem')) {
  $titulo = trim($_POST['titulo'] ?? '');
  $conteudo = trim($_POST['conteudo'] ?? '');
  // Não permitir editar a data; usar a data atual da publicação
  $data_publicacao = $pub['data_publicacao'];
  if ($titulo === '' || $conteudo === '') {
    $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        $imgPath = $pub['imagem'] ?? '../imagens/emoji.png';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../imagens/publicacoes';
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0775, true); }
            $tmp = $_FILES['imagem']['tmp_name'];
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $ext = $ext ? ('.' . strtolower($ext)) : '';
            $fileName = 'pub_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $ext;
            $dest = $uploadDir . '/' . $fileName;
            if (move_uploaded_file($tmp, $dest)) {
                $imgPath = '../imagens/publicacoes/' . $fileName;
        // Tornar esta a capa: empurrar ordens existentes e inserir como ordem 1
        $pdo->prepare('UPDATE publicacao_imagens SET ordem = ordem + 1 WHERE publicacao_id = ?')->execute([$id]);
        $pdo->prepare('INSERT INTO publicacao_imagens (publicacao_id, caminho, ordem) VALUES (?, ?, 1)')->execute([$id, $imgPath]);
            }
        }

  // Atualizar DB com título e imagem (sem alterar data)
  $upd = $pdo->prepare('UPDATE publicacoes SET titulo = ?, imagem = ? WHERE id = ?');
  $upd->execute([$titulo, $imgPath, $id]);

        // Gerar arquivo da publicação
        $fileRel = '../publicacoes/publicacao' . $id . '.php';
        $fileAbs = __DIR__ . '/../publicacoes/publicacao' . $id . '.php';
  // Buscar imagens para o carrossel
  $imgs = $pdo->prepare('SELECT caminho FROM publicacao_imagens WHERE publicacao_id = ? ORDER BY ordem ASC');
  $imgs->execute([$id]);
  $imagens = $imgs->fetchAll(PDO::FETCH_COLUMN) ?: [$imgPath];
  $htmlContent = buildPublicacaoFile($titulo, $data_publicacao, $imagens, $conteudo);
        file_put_contents($fileAbs, $htmlContent);

        // Atualizar caminho do arquivo
        $upd2 = $pdo->prepare('UPDATE publicacoes SET arquivo = ? WHERE id = ?');
        $upd2->execute([$fileRel, $id]);

        header('Location: ' . $fileRel);
        exit;
    }
}

function h($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function buildPublicacaoFile($titulo, $data, $imagens, $conteudo) {
    // Converte quebras de linha em parágrafos simples
    $paras = array_filter(array_map('trim', preg_split("/(\r\n|\n|\r)/", $conteudo)));
    $conteudoHtml = '';
    foreach ($paras as $p) { $conteudoHtml .= "\n          <p>" . htmlspecialchars($p, ENT_QUOTES, 'UTF-8') . "</p>"; }

  // Carousel indicators and items
  $indicators = '';
  $items = '';
  foreach ($imagens as $i => $img) {
    $active = $i === 0 ? 'active' : '';
    $indicators .= "\n              <button type=\"button\" data-bs-target=\"#carouselExampleIndicators\" data-bs-slide-to=\"{$i}\" class=\"" . ($active ? 'active' : '') . "\" " . ($active ? 'aria-current=\"true\"' : '') . " aria-label=\"Slide " . ($i+1) . "\"></button>";
    $items .= "\n              <div class=\"carousel-item {$active}\">\n                <img src=\"" . htmlspecialchars($img, ENT_QUOTES, 'UTF-8') . "\" class=\"d-block w-100\" alt=\"Imagem da publicação\">\n                <div class=\"carousel-caption d-none d-md-block\">\n                  <p>" . htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') . "</p>\n                </div>\n              </div>";
  }

    return <<<PHP
<?php
\$paginaAtiva = 'index'; 
\$fotoPerfil  = "../imagens/user-foto.png"; 
\$linkPerfil  = "../anonimo/login.php"; 
require '../include/navbar.php';
require '../include/menu-anonimo.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  /* Layout empilhado e centralizado para a página de publicação */
  .sobre-container { display: block; }
  .sobre-content { display: flex; flex-direction: column; gap: 24px; align-items: center; }
  .sobre-content .carousel { width: 100%; max-width: 960px; margin: 0 auto; }
  .post-content { width: 100%; max-width: 960px; margin: 0 auto; text-align: justify; }
</style>

<body>
  <div class="container-scroller">
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="titulo-publicacoes"> 
                  <h3 class="font-weight-bold">{$titulo}</h3>
                  <h6 class="font-weight-normal mb-0">Publicado em {$data}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="sobre-container">
          <div class="sobre-content">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">{$indicators}
            </div>
            <div class="carousel-inner">{$items}
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Próximo</span>
            </button>
          </div>

            <article class="post-content">
              {$conteudoHtml}
            </article>

            <?php include"../include/share.php";?>
          </div>
        </div>
      </div>
      <?php include"../include/footer.php";?>  
    </div>
  </div>
  <script src="../script.js"></script>
</body>
</html>
PHP;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <?php include __DIR__ . '/../include/head.php'; ?>
</head>
<body>
<?php
require __DIR__ . '/../include/navbar.php';
require __DIR__ . '/../include/menu-admin.php';
?>
<div class="container-scroller">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <h3 class="font-weight-bold">Criar Publicação</h3>
          <?php if ($erro): ?><div class="alert alert-danger"><?php echo h($erro); ?></div><?php endif; ?>
          <form method="post" enctype="multipart/form-data" id="formEditarPublicacao">
            <div class="form-group">
              <label for="titulo">Título</label>
              <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo h($pub['titulo']); ?>" required>
            </div>
            <div class="form-group">
              <label>Data</label><br>
              <span><?php echo h(date('d/m/Y', strtotime($pub['data_publicacao']))); ?></span>
            </div>
            <div class="form-group">
              <label>Imagem atual</label><br>
              <img src="<?php echo h($pub['imagem'] ?: '../imagens/emoji.png'); ?>" alt="Imagem" style="max-width: 300px; border-radius: 8px;">
            </div>
          
            <div class="form-group">
              <h4>Imagens da publicação</h4>
              <div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:12px;">
                <?php
                  $imgs = $pdo->prepare('SELECT caminho, ordem FROM publicacao_imagens WHERE publicacao_id = ? ORDER BY ordem ASC');
                  $imgs->execute([$id]);
                  foreach ($imgs as $img) {
                    $c = h($img['caminho']);
                    echo '<div style="width:160px; text-align:center;">'
                       . '<img src="' . $c . '" style="width:160px; height:100px; object-fit:cover; border-radius:8px;">'
                       . '<div style="font-size:12px; color:#666;">ordem ' . (int)$img['ordem'] . '</div>'
                       . '</div>';
                  }
                ?>
              </div>
              <div style="display:flex; gap:10px; align-items:center;">
                <input type="file" id="novaImagemInput" accept="image/*" class="form-control" style="max-width:320px;">
                <button type="button" class="btn btn-primary" id="btnAddImagem">Adicionar imagem</button>
              </div>
            </div>
            
            <div class="form-group">
              <label for="conteudo">Texto da Publicação</label>
              <textarea id="conteudo" name="conteudo" class="form-control" rows="10" placeholder="Escreva o conteúdo da publicação..." required></textarea>
            </div>
            <div class="modal-actions" style="display:flex; gap: 10px;">
              <button type="submit" class="btn btn-success">Salvar e publicar</button>
              <a href="./index-admin.php" class="btn btn-secondary">Cancelar</a>
            </div>
          </form>

          
        </div>
      </div>
    </div>
    <?php include __DIR__ . '/../include/footer.php'; ?>
  </div>
</div>
<script src="../script.js"></script>
<script>
  // Preservar texto digitado ao adicionar imagens (localStorage por publicação)
  (function(){
    const text = document.getElementById('conteudo');
    const addBtn = document.getElementById('btnAddImagem');
    const fileInput = document.getElementById('novaImagemInput');
    const formMain = document.getElementById('formEditarPublicacao');
    if (!text) return;
    const key = 'pub_text_id_' + <?php echo json_encode((int)$id); ?>;
    // Restaurar
    const saved = localStorage.getItem(key);
    if (saved && !text.value) { text.value = saved; }
    // Salvar em digitação
    text.addEventListener('input', ()=> localStorage.setItem(key, text.value));
    // Adicionar imagem via fetch sem recarregar
    addBtn?.addEventListener('click', async () => {
      if (!fileInput?.files?.length) { alert('Selecione uma imagem.'); return; }
      const file = fileInput.files[0];
      const fd = new FormData();
      fd.append('acao', 'add_imagem');
      fd.append('nova_imagem', file);
      try {
        localStorage.setItem(key, text.value);
        const resp = await fetch(window.location.href, { method: 'POST', body: fd });
        if (!resp.ok) throw new Error('Falha ao enviar imagem');
        window.location.reload();
      } catch (e) {
        alert('Erro ao adicionar imagem.');
      }
    });
    // Ao publicar com sucesso, limpar (será recarregado em outra página)
    formMain?.addEventListener('submit', ()=> localStorage.removeItem(key));
  })();
</script>
</body>
</html>
