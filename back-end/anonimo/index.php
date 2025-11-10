<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$paginaAtiva = 'index'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
// Conexão com o banco para carregar publicações 
require_once __DIR__ . '/../config/conexao.php';
function h($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

// Buscar publicações criadas pelos admins (tabela 'publicacoes')
$publicacoes = [];
try {
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
  $stmt = $pdo->query("SELECT id, titulo, resumo, imagem, arquivo, data_publicacao FROM publicacoes ORDER BY id DESC");
  $publicacoes = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (Throwable $e) {
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<?php include"../include/head.php"?>
<body>
<?php
require '../include/navbar.php';
require '../include/menu-anonimo.php';
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
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="row" id="publicacoes-container">
            <?php if (empty($publicacoes)): ?>
              <div class="col-12"><p>Nenhuma publicação cadastrada ainda.</p></div>
            <?php else: ?>
              <?php foreach ($publicacoes as $pub): 
                $id    = (int)($pub['id'] ?? 0);
                $titulo= h($pub['titulo'] ?? '');
                $resumo= h($pub['resumo'] ?? '');
                $img   = h($pub['imagem'] ?: '../imagens/emoji.png');
                $data  = h(date('d/m/Y', strtotime($pub['data_publicacao'])));
                $href  = $pub['arquivo'] ? h($pub['arquivo']) : ('../publicacoes/publicacao' . $id . '.php');
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
                      <a href="<?= $href ?>" class="btn btn-success">Ver detalhes</a>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        
        <!-- FOOTER -->
        <?php include '../include/footer.php'; ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>