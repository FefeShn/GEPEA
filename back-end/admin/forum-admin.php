<?php
session_start();
require_once '../config/auth.php';
require_once '../config/conexao.php';
require_once '../include/discussao_helpers.php';
requireAdmin();

$paginaAtiva = 'forum-admin';
$fotoPerfil  = "../imagens/computer.jpg";
$linkPerfil  = "../admin/biografia-admin.php";

$pdo = getConexao();
$participantes = [];
try {
  $stmt = $pdo->prepare("SELECT id_usuario, nome_user, cargo_user, eh_adm FROM usuarios ORDER BY nome_user");
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($rows as $row) {
      $participantes[$row['id_usuario']] = $row;
  }
  $participantes = array_values($participantes);
} catch (Throwable $e) {
  $participantes = [];
}

$discussoesUsuario = gepea_listar_discussoes_usuario((int)($_SESSION['id_usuario'] ?? 0), $pdo);

$flashSucesso = $_SESSION['flash_sucesso'] ?? '';
$flashErro    = $_SESSION['flash_erro'] ?? '';
unset($_SESSION['flash_sucesso'], $_SESSION['flash_erro']);

require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<body>
  <div class="container-scroller">

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="titulo-forum">
          <h3><i class="fas fa-comments"></i> Bate-papos</h3>
          <div class="forum-actions">
            <button class="btn btn-excluir-discussao">
              <i class="fas fa-trash"></i> Excluir Chats
            </button>
            <button class="btn btn-nova-discussao">
              <i class="fas fa-plus"></i> Novo Chat
            </button>
          </div>
        </div>

        <?php if ($flashSucesso): ?>
          <div class="alert alert-success"><?php echo htmlspecialchars($flashSucesso); ?></div>
        <?php endif; ?>
        <?php if ($flashErro): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($flashErro); ?></div>
        <?php endif; ?>

        <div class="discussoes-container" id="discussoes-container">
          <?php if (empty($discussoesUsuario)): ?>
            <p class="text-muted">Nenhum chat encontrado para você. Crie um novo usando o botão acima.</p>
          <?php else: ?>
            <?php foreach ($discussoesUsuario as $discussao): ?>
              <div class="discussao-card">
                <div class="discussao-info">
                  <h4><?php echo htmlspecialchars($discussao['titulo_discussao']); ?></h4>
                  <div class="discussao-meta">
                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($discussao['criador_nome']); ?></span>
                    <span><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($discussao['data_criacao'])); ?></span>
                    <span><i class="fas fa-users"></i> <?php echo (int)$discussao['total_participantes']; ?> participantes</span>
                  </div>
                </div>

                <div class="discussao-acoes">
                  <a href="discussao.php?id=<?php echo (int)$discussao['id_discussao']; ?>" class="btn-acessar">
                    <i class="fas fa-comments"></i> Acessar
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Modal Novo Chat -->
    <div class="modal-overlay" id="modalNovaDiscussao">
      <div class="modal-container">
        <div class="modal-header">
          <h3><i class="fas fa-plus-circle"></i> Criar Novo Chat</h3>
          <button class="modal-close" type="button">&times;</button>
        </div>
        <div class="modal-body">
          <form id="formNovaDiscussao" method="POST" action="../api/discussoes_criar.php">
            <div class="form-group">
              <label for="tituloDiscussao"><i class="fas fa-heading"></i> Título*</label>
              <input type="text" id="tituloDiscussao" name="titulo" placeholder="Dê um título claro para seu chat" required>
            </div>

            <div class="form-group">
              <label><i class="fas fa-users"></i> Participantes</label>
              <?php if ($participantes): ?>
                <div class="select-all-row">
                  <label class="checkbox-inline">
                    <input type="checkbox" id="selecionarTodosAdmin" data-select-all-target=".checkbox-participante-admin">
                    Selecionar todos
                  </label>
                </div>
                <div class="participant-list">
                  <?php foreach ($participantes as $participante): ?>
                    <label class="participant-option">
                      <input type="checkbox" class="checkbox-participante checkbox-participante-admin" name="participantes[]" value="<?php echo (int)$participante['id_usuario']; ?>">
                      <span>
                        <?php echo htmlspecialchars($participante['nome_user']); ?>
                        <?php if (!empty($participante['cargo_user'])): ?>
                          <small>- <?php echo htmlspecialchars($participante['cargo_user']); ?></small>
                        <?php endif; ?>
                      </span>
                    </label>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <p class="text-muted">Cadastre membros antes de criar um chat.</p>
              <?php endif; ?>
            </div>

            <input type="hidden" name="contexto" value="admin">

            <div class="modal-actions">
              <button type="button" class="cancel-button">Cancelar</button>
              <button type="submit" class="submit-button">Criar Chat</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Excluir Chats -->
    <div class="modal-overlay" id="modalExcluirDiscussao">
      <div class="modal-container confirm-modal">
        <div class="modal-header">
          <h3><i class="fas fa-exclamation-triangle"></i> Excluir Chats</h3>
          <button class="modal-close" type="button">&times;</button>
        </div>
        <div class="modal-body">
          <p>Selecione os chats que deseja remover. Essa ação não pode ser desfeita.</p>
          <div id="listaDiscussoesAdmin" class="membros-list small-text"></div>
        </div>
        <div class="modal-actions">
          <button class="cancel-button" id="cancelarExclusaoDiscussao">Cancelar</button>
          <button class="submit-button delete-button" id="confirmarExclusaoDiscussao"><i class="fas fa-trash"></i> Excluir Selecionadas</button>
        </div>
      </div>
    </div>

    <?php
      include"../include/footer.php";
    ?>
  </div>
  
  <script src="../script.js"></script>
</body>
</html>