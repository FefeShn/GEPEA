<?php
session_start();
require '../config/auth.php';
require_once '../config/conexao.php';
require_once '../config/email.php';

if (!isAdmin()) {
    header('Location: ../anonimo/login.php');
    exit();
}

$error = '';
$success = '';

// Gera senha aleatória para novo membro
function gerarSenhaAleatoria(int $len = 12): string {
    $alfabeto = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789@$%';
    $bytes = random_bytes($len);
    $senha = '';
    for ($i=0; $i<$len; $i++) {
        $senha .= $alfabeto[ord($bytes[$i]) % strlen($alfabeto)];
    }
    return $senha;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nomeMembro'] ?? '');
    $email = trim($_POST['emailMembro'] ?? '');
    $cargo = $_POST['cargoMembro'] ?? '';
    $lattes = trim($_POST['lattesMembro'] ?? '');
    $senhaGerada = gerarSenhaAleatoria();
    $foto = '';

    if (isset($_FILES['fotoMembro']) && $_FILES['fotoMembro']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['fotoMembro']['name'], PATHINFO_EXTENSION);
        $foto = '../imagens/' . uniqid('membro_') . '.' . $ext;
        move_uploaded_file($_FILES['fotoMembro']['tmp_name'], $foto);
    }
    if (empty($foto)) {
        $foto = '../imagens/user-foto.png';
    }

    if (empty($nome) || empty($email) || empty($cargo)) {
        $error = 'Preencha todos os campos obrigatórios!';
    } else {
        $pdo = getConexao();
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email_user = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = 'Já existe um membro com esse e-mail!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome_user, email_user, senha_user, foto_user, eh_adm, cargo_user, lattes_user) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $eh_adm = 0;
            $hashSenha = password_hash($senhaGerada, PASSWORD_DEFAULT);
            $stmt->execute([
                $nome,
                $email,
                $hashSenha,
                $foto,
                $eh_adm,
                $cargo,
                $lattes
            ]);
            // Envia credenciais por e-mail
            $assunto = 'GEPEA - Acesso inicial do membro';
            $html = '<p>Olá ' . htmlspecialchars($nome) . ',</p>'
                  . '<p>Você foi cadastrado no GEPEA.</p>'
                  . '<p><strong>Login:</strong> ' . htmlspecialchars($email) . '<br>'
                  . '<strong>Senha inicial:</strong> ' . htmlspecialchars($senhaGerada) . '</p>'
                  . '<p>Recomendação: ao primeiro acesso, altere sua senha (quando a funcionalidade estiver disponível).</p>'
                  . '<p>Abraço,<br>Equipe GEPEA</p>';
            gepea_send_mail($email, $nome, $assunto, $html);
            $success = 'Membro cadastrado e credenciais enviadas por e-mail.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php include "../include/head.php"; ?>
<body>
    <?php include "../include/navbar.php"; ?>
    <div class="body-login">
    <div class="container-scroller">
        <div class="main-panel">
            <div class="content-wrapper">
                
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <div class="support-form-container">
                    <div class="members-header">
                    <h1 class="page-title">Cadastrar Novo Membro</h1>
                    <div class="members-actions">
                        <a href="membros-admin.php" class="add-member-button">
                            <i class="ti-arrow-left"></i>Voltar para membros
                        </a>
                    </div>
                </div>
                    <form action="add-membro.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nomeMembro">Nome Completo *</label>
                            <input type="text" name="nomeMembro" id="nomeMembro" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="emailMembro">Email *</label>
                            <input type="email" name="emailMembro" id="emailMembro" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="cargoMembro">Cargo no Grupo *</label>
                            <select name="cargoMembro" id="cargoMembro" class="form-control" required>
                                <option value="" disabled selected>Selecione o cargo...</option>
                                <option value="coordenador">Coordenador</option>
                                <option value="vice-coordenador">Vice-Coordenador</option>
                                <option value="bolsista">Bolsista</option>
                                <option value="membro">Membro</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="lattesMembro">Currículo Lattes</label>
                            <input type="text" name="lattesMembro" id="lattesMembro" class="form-control">
                        </div>
                                                
                        <div class="form-group">
                            <label for="fotoMembro">Foto do Perfil</label>
                            <div class="file-upload-container">
                                <input type="file" name="fotoMembro" id="fotoMembro" class="file-input" accept="image/jpeg,image/png" hidden>
                                <label for="fotoMembro" class="file-upload-button">
                                    <i class="ti-camera"></i>
                                    <span class="file-upload-text">Selecionar Foto</span>
                                </label>
                                <span class="file-name" id="fileName">Nenhum arquivo selecionado</span>
                            </div>
                            <small class="legenda">Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB</small>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-plus"></i>Cadastrar Membro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>