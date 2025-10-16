<?php
$paginaAtiva = 'nenhum'; 
$fotoPerfil  = "../imagens/computer.jpg"; 
$linkPerfil  = "../anonimo/login.php"; 

session_start();
require '../config/conexao.php'; 
$conn = getConexao();

$idUsuario = $_SESSION['id_usuario']; // pega o id do usuário logado

// busca os dados do usuário
$sql = "SELECT nome_user, email_user, foto_user, bio_user, cargo_user, lattes_user FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// define variáveis com fallback (caso algo esteja vazio)
$fotoPerfil  = $usuario['foto_user'] ?: "../imagens/user-foto.png";
$nome        = $usuario['nome_user'];
$email       = $usuario['email_user'];
$lattes      = $usuario['lattes_user'];
$cargo       = $usuario['cargo_user'];
$bio         = $usuario['bio_user'] ?: "Nenhuma biografia cadastrada ainda.";

require '../include/navbar.php';
require '../include/menu-admin.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php include"../include/head.php"?>

<body>
  
  <div class="container-scroller">
    
      <!-- CONTEÚDO PRINCIPAL -->
      <main class="biography-container">
      <div class="biography-header">
        <div class="biography-title-wrapper">
          <h1 class="biography-title">Biografia</h1>
          <a href="membros-admin.php" class="back-button">← Voltar aos membros</a>
        </div>
        <button class="edit-button">
          <i class="ti-pencil"></i> Editar biografia
        </button>
      </div>
      
      <div class="biography-content">
        <div class="biography-photo">
          <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Foto de <?php echo htmlspecialchars($nome); ?>" class="profile-image">
            <button class="change-photo-button">
                <i class="ti-camera"></i> Alterar foto de perfil
            </button>
        </div>
        
        <div class="biography-info">
          <h2 class="member-name"><?php echo htmlspecialchars($nome); ?></h2>
            <p class="member-role"><?php echo htmlspecialchars($cargo); ?></p>
            <a href="<?php echo htmlspecialchars($lattes); ?>" target="_blank" class="lattes-link">...</a>
            <a href="mailto:<?php echo htmlspecialchars($email); ?>" class="email-link">...</a>
            <div class="biography-text">
              <p><?php echo nl2br(htmlspecialchars($bio)); ?></p>
            </div>

        </div>
      </div>
    </main>
        
        <!-- FOOTER -->
        <?php
          include"../include/footer.php";
        ?>
      </div>
      <!-- main-panel ends -->
    </div>   
  </div>
  <script src="../script.js"></script>
</body>

</html>