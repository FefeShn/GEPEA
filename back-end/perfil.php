<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$paginaAtiva = 'nenhuma';
$fotoPerfil  = isset($_SESSION['foto_user']) && $_SESSION['foto_user'] ? $_SESSION['foto_user'] : "../imagens/user-foto.png";
$linkPerfil  = isset($_SESSION['id_usuario']) ? (($_SESSION['eh_adm'] ?? false) ? '../admin/index-admin.php' : '../membro/index-membro.php') : '../anonimo/login.php';
require_once __DIR__ . '/config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$usuario = null;
if ($id) {
    try {
        $pdo = getConexao();
        $stmt = $pdo->prepare('SELECT id_usuario, nome_user, email_user, foto_user, bio_user, cargo_user, lattes_user FROM usuarios WHERE id_usuario = ?');
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (Throwable $e) {
        $usuario = null;
    }
}
function caminhoFotoPerfil(?string $foto): string {
  if ($foto === null) return './imagens/user-foto.png';
  $foto = trim((string)$foto);
  if ($foto === '') return './imagens/user-foto.png';
  if (preg_match('#^(https?:)?//#', $foto) || substr($foto, 0, 1) === '/') return $foto;
  if (strpos($foto, '../') === 0) return './' . substr($foto, 3);
  if (strpos($foto, './') === 0) return $foto;
  return './imagens/' . ltrim($foto, '/');
}
function cargoClass(string $cargo): string {
    $c = mb_strtolower($cargo, 'UTF-8');
    if (strpos($c, 'vice') !== false && strpos($c, 'coorden') !== false) return 'vice-coordenador';
    if (strpos($c, 'coordenador') !== false) return 'coordenador';
    if (strpos($c, 'bolsista') !== false) return 'bolsista';
    if (strpos($c, 'membro') !== false) return 'membro';
    return 'outros';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include __DIR__ . '/include/head.php'; ?>
<body>
<?php
  require __DIR__ . '/include/navbar.php';
  require __DIR__ . '/include/menu-dinamico.php';
?>
<div class="container-scroller">
  <main class="biography-container">
    <?php if (!$usuario): ?>
      <div class="biography-header">
        <div class="biography-title-wrapper">
          <h1 class="biography-title">Perfil</h1>
          <a href="javascript:history.back()" class="back-button">← Voltar</a>
        </div>
      </div>
      <div class="biography-content">
        <div class="biography-info" style="flex:1;">
          <h2 class="member-name">Perfil não encontrado</h2>
          <p class="member-role">O perfil informado não existe ou foi removido.</p>
        </div>
      </div>
    <?php else: ?>
      <?php
        $nome   = htmlspecialchars($usuario['nome_user'] ?? '');
        $cargo  = htmlspecialchars($usuario['cargo_user'] ?? '');
        $email  = htmlspecialchars($usuario['email_user'] ?? '');
        $lattes = trim((string)($usuario['lattes_user'] ?? ''));
        $bioRaw = trim((string)($usuario['bio_user'] ?? ''));
        $bio    = $bioRaw !== '' ? nl2br(htmlspecialchars($bioRaw)) : 'Sem biografia.';
        $foto   = caminhoFotoPerfil($usuario['foto_user'] ?? null);
        $roleClass = cargoClass($usuario['cargo_user'] ?? '');
      ?>
      <div class="biography-inner">
        <div class="biography-header">
          <div class="biography-title-wrapper">
            <h1 class="biography-title">Perfil</h1>
            <a href="javascript:history.back()" class="back-button">← Voltar</a>
          </div>
        </div>
        <div class="biography-content <?= $roleClass ?>">
          <div class="biography-photo">
            <img src="<?= htmlspecialchars($foto) ?>" alt="Foto de <?= $nome ?>" class="profile-image">
          </div>
          <div class="biography-info">
            <h2 class="member-name"><?= $nome ?></h2>
            <?php if ($cargo !== ''): ?>
              <p class="member-role <?= $roleClass ?>"><?= $cargo ?></p>
            <?php endif; ?>
            <div class="member-contacts">
              <?php if ($lattes !== ''): ?>
                <a href="<?= htmlspecialchars($lattes) ?>" target="_blank" class="lattes-link">
                  <img src="./imagens/lattes-icon.png" alt="Currículo Lattes" class="contact-icon">
                  Currículo Lattes
                </a>
              <?php endif; ?>
              <?php if ($email !== ''): ?>
                <a href="mailto:<?= $email ?>" class="email-link">
                  <img src="./imagens/email-icon.png" alt="Email" class="contact-icon">
                  <?= $email ?>
                </a>
              <?php endif; ?>
            </div>
            <div class="biography-text">
              <p class="biography-text-content"><?= $bio ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>
  <?php include __DIR__ . '/include/footer.php'; ?>
</div>
<script src="./script.js"></script>
</body>
</html>
