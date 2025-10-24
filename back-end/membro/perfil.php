<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
// Página de perfil dinâmica baseada em biografia-membro.php
// URL esperada: perfil.php?id=ID_DO_USUARIO

// Variáveis opcionais (mantidas por consistência com outras páginas)
$paginaAtiva = 'nenhuma';
$fotoPerfil  = "../imagens/user-foto.png"; // padrão para a navbar quando anônimo
$linkPerfil  = "../anonimo/login.php";

require_once '../config/conexao.php';

// Captura e valida o id
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$usuario = null;
if ($id) {
    try {
        $pdo = getConexao();
        $stmt = $pdo->prepare('SELECT id_usuario, nome_user, email_user, foto_user, bio_user, cargo_user, lattes_user FROM usuarios WHERE id_usuario = ?');
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (Throwable $e) {
        // Mantém $usuario como null em caso de falha, mensagem amigável será exibida
        $usuario = null;
    }
}

// Funções auxiliares simples
function caminhoFotoPerfil(?string $foto): string {
    // Foto padrão
    if (!$foto || trim($foto) === '') {
        return '../imagens/user-foto.png';
    }
    // Se já for URL absoluta ou path root, retorna como está
    if (preg_match('#^(https?:)?//#', $foto) || substr($foto, 0, 1) === '/') {
        return $foto;
    }
    // Se já vier com ../ assume relativo válido
    if (strpos($foto, '../') === 0) {
        return $foto;
    }
    // Caso contrário, usa a pasta de imagens padrão
    return '../imagens/' . ltrim($foto, '/');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include "../include/head.php"; ?>
<body>
  <?php
    require '../include/navbar.php';
    require '../include/menu-membro.php';
  ?>
  <div class="container-scroller">
    <!-- CONTEÚDO PRINCIPAL -->
    <main class="biography-container">
      <?php if (!$usuario): ?>
        <div class="biography-header">
          <div class="biography-title-wrapper">
            <h1 class="biography-title">Perfil</h1>
            <a href="membros-membro.php" class="back-button">← Voltar aos membros</a>
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
          $bio    = $bioRaw !== '' ? nl2br(htmlspecialchars($bioRaw)) : 'Adicionar biografia';
          $foto   = caminhoFotoPerfil($usuario['foto_user'] ?? null);
          // Define classe de cargo para aplicar cores e estilos relacionados
          $cargoLower = mb_strtolower($usuario['cargo_user'] ?? '', 'UTF-8');
          $roleClass = 'outros';
          if (strpos($cargoLower, 'vice') !== false && strpos($cargoLower, 'coorden') !== false) {
              $roleClass = 'vice-coordenador';
          } elseif (strpos($cargoLower, 'coordenador') !== false) {
              $roleClass = 'coordenador';
          } elseif (strpos($cargoLower, 'bolsista') !== false) {
              $roleClass = 'bolsista';
          } elseif (strpos($cargoLower, 'membro') !== false) {
              $roleClass = 'membro';
          }
        ?>

        <div class="biography-inner">
          <div class="biography-header">
            <div class="biography-title-wrapper">
              <h1 class="biography-title">Biografia</h1>
              <a href="membros-membro.php" class="back-button">← Voltar aos membros</a>
            </div>
          </div>

          <div class="biography-content <?= $roleClass ?>">
          <div class="biography-photo">
            <img src="<?= htmlspecialchars($foto) ?>" alt="Foto de <?= $nome ?>" class="profile-image">
            <button class="change-photo-button">
              <i class="ti-camera"></i> Alterar foto de perfil
            </button>
          </div>

          <div class="biography-info">
            <h2 class="member-name">
              <?= $nome ?>
            </h2>
            <?php if ($cargo !== ''): ?>
              <p class="member-role <?= $roleClass ?>">
                <?= $cargo ?>
              </p>
            <?php endif; ?>

            <div class="member-contacts">
              <?php if ($lattes !== ''): ?>
                <a href="<?= htmlspecialchars($lattes) ?>" target="_blank" class="lattes-link">
                  <img src="../imagens/lattes-icon.png" alt="Currículo Lattes" class="contact-icon">
                  Currículo Lattes
                </a>
              <?php endif; ?>

              <?php if ($email !== ''): ?>
                <a href="mailto:<?= $email ?>" class="email-link">
                  <img src="../imagens/email-icon.png" alt="Email" class="contact-icon">
                  <?= $email ?>
                </a>
              <?php endif; ?>
              <button type="button" class="btn btn-primary edit-contacts-button" data-user-id="<?= (int)$usuario['id_usuario'] ?>">
                <i class="ti-pencil"></i> Editar contatos
              </button>
            </div>

            <div class="biography-text">
              <p class="biography-text-content"><?= $bio ?></p>
            </div>
            <button class="edit-button edit-biography-button" type="button">
              <i class="ti-pencil"></i> Editar biografia
            </button>
          </div>
          </div>
        </div>

        <!-- Modal: Editar Contatos -->
        <div class="modal-overlay" id="modalContato" aria-hidden="true">
          <div class="modal-container" role="dialog" aria-modal="true" aria-labelledby="tituloModalContato">
            <div class="modal-header">
              <h3 id="tituloModalContato">Editar contatos</h3>
              <button class="modal-close" type="button" aria-label="Fechar">&times;</button>
            </div>
            <div class="modal-body">
              <form id="formEditarContato">
                <input type="hidden" name="id_usuario" value="<?= (int)$usuario['id_usuario'] ?>">
                <div class="form-group">
                  <label for="emailEditar">Email</label>
                  <input type="email" id="emailEditar" name="email" class="form-control" value="<?= $email ?>" required>
                </div>
                <div class="form-group">
                  <label for="lattesEditar">Currículo Lattes (URL)</label>
                  <input type="url" id="lattesEditar" name="lattes" class="form-control" value="<?= htmlspecialchars($lattes) ?>" placeholder="http://lattes.cnpq.br/...">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary close-modal" type="button">Cancelar</button>
              <button class="btn btn-primary" id="salvarContato" type="button">Salvar</button>
            </div>
          </div>
        </div>

        <!-- Modal: Alterar Foto -->
        <div class="modal-overlay" id="modalFoto" aria-hidden="true">
          <div class="modal-container" role="dialog" aria-modal="true" aria-labelledby="tituloModalFoto">
            <div class="modal-header">
              <h3 id="tituloModalFoto">Alterar foto de perfil</h3>
              <button class="modal-close" type="button" aria-label="Fechar">&times;</button>
            </div>
            <div class="modal-body">
              <form id="formEditarFoto" enctype="multipart/form-data">
                <input type="hidden" name="id_usuario" value="<?= (int)$usuario['id_usuario'] ?>">
                <div class="form-group">
                  <label for="arquivoFoto">Selecione uma imagem (JPG, PNG, até 2MB)</label>
                  <input type="file" id="arquivoFoto" name="foto" class="form-control" accept="image/jpeg,image/png" required>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary close-modal" type="button">Cancelar</button>
              <button class="btn btn-primary" id="salvarFoto" type="button">Salvar</button>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <?php include "../include/footer.php"; ?>
  </div>
  <script src="../script.js"></script>
</body>
</html>
