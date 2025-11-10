<?php
// Sessão/variáveis de navegação
if (session_status() === PHP_SESSION_NONE) { session_start(); }
// Definir página ativa conforme login para manter destaque no menu correto
$isLoggedIn = !empty($_SESSION['id_usuario']);
$paginaAtiva = $isLoggedIn ? 'eventos-membro' : 'eventos'; 
$fotoPerfil  = "../imagens/user-foto.png"; 
$linkPerfil  = "login.php"; 
require '../include/navbar.php';
// Menu dinâmico conforme sessão
require '../include/menu-dinamico.php';

// Conexão e utilidades
require_once __DIR__ . '/../config/conexao.php';
function h($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }
function cut($s, $len = 180) {
  if ($s === null) return '';
  if (function_exists('mb_strlen')) {
    return mb_strlen($s, 'UTF-8') > $len ? (mb_substr($s, 0, $len, 'UTF-8') . '…') : $s;
  }
  return strlen($s) > $len ? (substr($s, 0, $len) . '…') : $s;
}

// Buscar eventos (tabela 'evento'); detalhe é gerado em ../eventos/evento<ID>.php
$eventos = [];
try {
  $pdo = getConexao();
  $pdo->exec("CREATE TABLE IF NOT EXISTS evento (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo_evento VARCHAR(255) NOT NULL,
    conteudo_evento TEXT NOT NULL,
    data_evento DATETIME NOT NULL,
    foto_evento VARCHAR(512) DEFAULT NULL,
    id_usuario INT NOT NULL
  )");
  $stmt = $pdo->query("SELECT id_evento, titulo_evento, conteudo_evento, data_evento, foto_evento FROM evento ORDER BY id_evento DESC");
  $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (Throwable $e) {
  // Em caso de erro, manter vazio e exibir estado amigável
}
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
                    <h3 class="font-weight-bold">Eventos</h3>
                    <h6 class="font-weight-normal mb-0">Últimos eventos do grupo</h6>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="row" id="publicacoes-container">
            <?php if (empty($eventos)): ?>
              <div class="col-12"><p>Nenhum evento cadastrado ainda.</p></div>
            <?php else: ?>
              <?php foreach ($eventos as $ev): 
                $id    = (int)($ev['id_evento'] ?? 0);
                $titulo= h($ev['titulo_evento'] ?? '');
                // Pequeno resumo a partir do conteúdo (sem quebrar o visual)
                $resumo= trim($ev['conteudo_evento'] ?? '');
                $resumo= h(cut($resumo, 180));
                $img   = h($ev['foto_evento'] ?: '../imagens/emoji.png');
                $data  = h(date('d/m/Y', strtotime($ev['data_evento'])));
                $href  = '../eventos/evento' . $id . '.php';
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
        <?php
          include'../include/footer.php';
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>