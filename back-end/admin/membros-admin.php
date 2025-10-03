<?php
session_start();
require '../config/auth.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_membro'])) {
    $nome = $_POST['nomeMembro'] ?? '';
    $email = $_POST['emailMembro'] ?? '';
    $cargo = $_POST['cargoMembro'] ?? '';
    $lattes = $_POST['lattesMembro'] ?? '';
    $senha = $_POST['senhaMembro'] ?? '';
    $foto = '';

    if (isset($_FILES['fotoMembro']) && $_FILES['fotoMembro']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['fotoMembro']['name'], PATHINFO_EXTENSION);
        $foto = '../imagens/' . uniqid('membro_') . '.' . $ext;
        move_uploaded_file($_FILES['fotoMembro']['tmp_name'], $foto);
    }

    if (empty($foto)) {
        $foto = '../imagens/user-foto.png';
    }

    $pdo = getConexao();
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email_user = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $mensagem = 'Já existe um membro com esse e-mail!';
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome_user, email_user, senha_user, foto_user, eh_adm, cargo_user, lattes_user) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $eh_adm = 0; 
        $stmt->execute([
            $nome,
            $email,
            $senha,
            $foto,
            $eh_adm,
            $cargo,
            $lattes
        ]);
        $mensagem = 'Membro cadastrado com sucesso!';
    }
}

$pdo = getConexao();
$stmt = $pdo->prepare("SELECT id_usuario, nome_user, foto_user, cargo_user FROM usuarios ORDER BY nome_user");
$stmt->execute();
$membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
$paginaAtiva = 'membros-admin'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../admin/biografia-admin.php"; 
require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>
<body>
  
  <div class="container-scroller">

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="members-container">
        <div class="members-header">
            <h1 class="page-title">Nossos Membros</h1>
            <div class="members-actions">
                <a href="add-membro.php" class="add-member-button">
                    <i class="ti-plus"></i> Cadastrar novo membro
                </a>
                <button class="delete-member-button" id="deleteMemberButton">
                  <i class="ti-trash"></i> Excluir membro
                </button>
            </div>
        </div>
        
        <div class="members-grid">
            <?php foreach ($membros as $membro): ?>
                <div class="member-card-wrapper">
                    <a href="../biografias/biografia<?= $membro['id_usuario'] ?>.php" class="member-card">
                        <div class="member-photo">
                            <img src="<?= !empty($membro['foto_user']) ? $membro['foto_user'] : '../imagens/user-foto.png' ?>" alt="Foto do Membro">
                        </div>
                        <h3 class="member-name"><?= htmlspecialchars($membro['nome_user']) ?></h3>
                        <p class="member-role"><?= htmlspecialchars($membro['cargo_user']) ?></p>
                    </a>
                    <input type="checkbox" class="member-checkbox">
                </div>
            <?php endforeach; ?>
        </div>
    </main>
        
    

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal-overlay" id="modalExcluirMembro">
      <div class="modal-container confirm-modal">
        <div class="modal-header">
          <h3>Confirmar Exclusão</h3>
        </div>
        <div class="modal-body">
          <p>Tem certeza que deseja excluir o(s) membro(s) selecionado(s)? Esta ação não pode ser desfeita.</p>
        </div>
        <div class="modal-actions">
          <button class="cancel-button" id="cancelarExclusao">Não, cancelar</button>
          <button class="submit-button delete-button" id="confirmarExclusao">Sim, excluir</button>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <?php
      include"../include/footer.php";
    ?>
  </div>
  <script src="../script.js"></script>
</body>
</html>