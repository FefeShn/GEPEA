<?php
session_start();
require_once '../config/auth.php';
require_once '../config/conexao.php';
require_once '../include/discussao_helpers.php';
requireAdmin();

$paginaAtiva = 'forum-admin';
$discussaoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$usuarioId = (int)($_SESSION['id_usuario'] ?? 0);
$erroDiscussao = '';
$discussaoDados = null;
$participantesDiscussao = [];

if ($discussaoId > 0) {
    [$discussaoDados, $participantesDiscussao] = gepea_buscar_discussao_para_usuario($discussaoId, $usuarioId);
    if (!$discussaoDados) {
        $erroDiscussao = 'Você não tem acesso a esta discussão ou ela não existe.';
    }
} else {
    $erroDiscussao = 'Discussão não encontrada.';
}

require '../include/navbar.php';
require '../include/menu-admin.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include '../include/head.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<body>
<div class="container-scroller">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="chat-header-with-back">
        <a href="forum-admin.php" class="btn-voltar">
          <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div class="chat-header-info">
          <h3><?php echo htmlspecialchars($discussaoDados['titulo_discussao'] ?? 'Discussão'); ?></h3>
          <?php if ($discussaoDados): ?>
            <p>Criado por <?php echo htmlspecialchars($discussaoDados['criador_nome']); ?> em <?php echo date('d/m/Y', strtotime($discussaoDados['data_criacao'])); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <?php if ($erroDiscussao): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($erroDiscussao); ?></div>
      <?php else: ?>
        <div class="chat-container">
          <div class="chat-messages">
            <div class="message message-empty">
              <div class="message-text">Nenhuma mensagem ainda. Use o campo abaixo para iniciar.</div>
            </div>
          </div>
        </div>

        <div class="reply-container" style="display: none;">
          <div class="reply-preview">
            <span class="reply-label">Respondendo a:</span>
            <span class="reply-sender"></span>
            <span class="reply-text"></span>
            <button class="cancel-reply">✕</button>
          </div>
        </div>

        <div class="chat-input-container">
          <div class="chat-input">
            <textarea placeholder="Digite sua mensagem..."></textarea>
          </div>
          <div class="chat-actions">
            <button type="button" class="btn-emoji">
              <img src="../../site-front/imagens/emoji.png" alt="emoji" class="emoji-button">
            </button>
            <button type="button" class="btn-enviar">
              <img src="../imagens/enviar.png" alt="enviar" class="enviar-button">
            </button>
          </div>
        </div>

        <div class="participantes-box" style="margin-top:2rem;">
          <h5>Participantes</h5>
          <ul>
            <?php foreach ($participantesDiscussao as $participante): ?>
              <li><?php echo htmlspecialchars($participante['nome_user']); ?><?php if (!empty($participante['cargo_user'])): ?> <small>- <?php echo htmlspecialchars($participante['cargo_user']); ?></small><?php endif; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </div>
    <?php include '../include/footer.php'; ?>
  </div>
</div>
<script src="../script.js"></script>
</body>
</html>
